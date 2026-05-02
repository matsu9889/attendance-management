<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;

class AttendanceController extends Controller
{
    // 時間取得
    public function getTime()
    {
        $now = new Carbon();
        $date = $now->isoFormat('YYYY年MM月DD日(ddd)');
        $time = $now->format('H:i');
        return ['now' => $now, 'date' => $date, 'time' => $time];
    }

    // 勤怠登録画面表示
    public function create()
    {
        $result = $this->getTime();
        $date = $result['date'];
        $time = $result['time'];
        return view('attendance.create', compact('date', 'time'));
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

        $request->session()->put('work_status', '出勤中');
        return view('attendance.create', compact('date', 'time'));
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

        $request->session()->put('work_status', '退勤済');
        return view('attendance.create', compact('date', 'time'));
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

        $request->session()->put('work_status', '休憩中');
        return view('attendance.create', compact('date', 'time'));
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

        $request->session()->put('work_status', '出勤中');
        return view('attendance.create', compact('date', 'time'));
    }

    // 勤怠一覧画面
    public function index()
    {
        $result = $this->getTime();
        $date = $result['date'];
        $start = $result['now']->copy()->startOfMonth();
        $end = $result['now']->copy()->endOfMonth();

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

                // フォーマット
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
        return view('attendance.index', compact('attendances', 'days'));
    }
}
