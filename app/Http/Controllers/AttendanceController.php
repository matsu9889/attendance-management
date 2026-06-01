<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\CorrectionRequest;
use App\Models\CorrectionRequestBreak;
use App\Models\User;
use App\Http\Requests\AttendanceRequest;

class AttendanceController extends Controller
{
    // 時間取得
    public function getTime()
    {
        $now = new Carbon();
        $year = $now->format('Y');
        $month = $now->format('m');
        $date = $now->isoFormat('YYYY年MM月DD日(ddd)');
        $time = $now->format('H:i');
        return ['now' => $now, 'year' => $year, 'month' => $month, 'date' => $date, 'time' => $time];
    }

    // 勤怠登録画面表示
    public function create()
    {
        $result = $this->getTime();
        $date = $result['date'];
        $time = $result['time'];
        $now = $result['now'];

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $now->format('Y-m-d'))
            ->first();

        if (!$attendance) {
            $work_status = '勤務外';
        } elseif (!$attendance->end_time) {
            $breaking = BreakRecord::where('attendance_id', $attendance->id)
                ->whereNull('end_time')
                ->exists();
            $work_status = $breaking ? '休憩中' : '出勤中';
        } else {
            $work_status = '退勤済';
        }

        return view('attendance.create', compact('date', 'time', 'work_status'));
    }

    // 出勤登録機能
    public function clockIn(Request $request)
    {
        $result = $this->getTime();
        $now = $result['now'];
        $date = $result['date'];
        $time = $result['time'];

        $exists = Attendance::where('user_id', auth()->id())
            ->where('date', $now->format('Y-m-d'))
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['message' => '本日はすでに出勤済みです']);
        }

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $now->format('Y-m-d'),
            'start_time' => $now->format('H:i'),
            'end_time' => NULL,
        ]);

        return redirect('/attendance');
    }

    // 退勤機能
    public function clockOut(Request $request)
    {
        $result = $this->getTime();
        $now = $result['now'];
        $date = $result['date'];
        $time = $result['time'];

        Attendance::where('user_id', auth()->id(),)
            ->whereNull('end_time')
            ->update([
                'end_time' => $now->format('H:i'),
            ]);

        return redirect('/attendance');
    }

    // 休憩入機能
    public function breakIn(Request $request)
    {
        $result = $this->getTime();
        $now = $result['now'];
        $date = $result['date'];
        $time = $result['time'];

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $now->format('Y-m-d'))
            ->first();

        BreakRecord::create([
            'attendance_id' => $attendance->id,
            'start_time' => $now->format('H:i'),
            'end_time' => NULL,
        ]);

        return redirect('/attendance');
    }

    // 休憩戻機能
    public function breakOut(Request $request)
    {
        $result = $this->getTime();
        $now = $result['now'];
        $date = $result['date'];
        $time = $result['time'];

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $now->format('Y-m-d'))
            ->first();

        BreakRecord::where('attendance_id', $attendance->id,)
            ->whereNull('end_time')
            ->update([
                'end_time' => $now->format('H:i'),
            ]);

        return redirect('/attendance');
    }

    // 勤怠一覧画面
    public function index()
    {
        $result = $this->getTime();
        // $date = $result['date'];

        $year = request('year') ?? $result['year'];
        $month = request('month') ?? $result['month'];
        $currentMonth = Carbon::create($year, $month, 1);

        $start = $currentMonth->copy()->startOfMonth();
        $end = $currentMonth->copy()->endOfMonth();

        $subMonth = $currentMonth->copy()->subMonths(1);
        $thisMonth = $currentMonth->copy()->format('Y/m');
        $addMonth = $currentMonth->copy()->addMonths(1);

        $days = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $days[] = [
                'key' => $current->format('Y-m-d'),      // 照合用
                'label' => $current->isoFormat('MM/DD(ddd)'), // 表示用
            ];
            $current->addDay();
        }

        $attendances = Attendance::where('user_id', auth()->id())
            ->with('breakRecord')
            ->whereBetween('date', [$start, $end])
            ->get()
            ->keyBy('date');

        foreach ($attendances as $attendance) {
            if ($attendance->start_time && $attendance->end_time) {
                $work_minutes = Carbon::parse($attendance->end_time)
                    ->diffInMinutes(Carbon::parse($attendance->start_time));

                $break_total = 0;

                foreach ($attendance->breakRecord as $break) {
                    if ($break->start_time && $break->end_time) {
                        $break_total += Carbon::parse($break->end_time)
                            ->diffInMinutes(Carbon::parse($break->start_time));
                    }
                }

                $work_total = $work_minutes - $break_total;

                $attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
                $attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');

                $attendance->break_total = floor($break_total / 60) . ':' . str_pad($break_total % 60, 2, '0', STR_PAD_LEFT);
                $attendance->work_total = floor($work_total / 60) . ':' . str_pad($work_total % 60, 2, '0', STR_PAD_LEFT);
            } else {
                $attendance->start_time = null;
                $attendance->end_time = null;
                $attendance->break_total = null;
                $attendance->work_total = null;
            }
        }
        return view('attendance.index', compact('attendances', 'days', 'thisMonth', 'subMonth', 'addMonth'));
    }

    // 勤怠詳細画面表示
    public function show($id)
    {
        $user = auth()->user();
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('id', $id)
            ->with('breakRecord')
            ->first();

        $year = Carbon::parse($attendance->date)->isoFormat('YYYY年');
        $date = Carbon::parse($attendance->date)->isoFormat('M月D日');

        $attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
        $attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');

        foreach ($attendance->breakRecord as $break) {
            $break->start_time = Carbon::parse($break->start_time)->format('H:i');
            $break->end_time = Carbon::parse($break->end_time)->format('H:i');
        }

        $approval = CorrectionRequest::where('approval', 0)
            ->where('attendance_id', $attendance->id)
            ->exists();

        return view('attendance.show', compact('id', 'user', 'attendance', 'year', 'date', 'approval'));
    }

    public function correct($id, AttendanceRequest $request)
    {
        $correctionRequest = CorrectionRequest::create([
            'attendance_id' => $id,
            'start_time' => $request->attendance_start_time,
            'end_time' => $request->attendance_end_time,
            'comment' => $request->comment,
        ]);

        foreach ($request->break_start_time as $index => $start) {
            if ($start != NULL)
                CorrectionRequestBreak::create([
                    'correction_request_id' => $correctionRequest->id,
                    'start_time' => $start,
                    'end_time' => $request->break_end_time[$index],
                ]);
        }
        return redirect('/stamp_correction_request/list');
    }
}
