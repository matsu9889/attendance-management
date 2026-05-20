<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\CorrectionRequest;
use App\Models\CorrectionRequestBreak;
use App\Http\Requests\AttendanceRequest;
use App\Models\BreakRecord;

class AttendanceController extends Controller
{
    public function index()
    {
        $now = new Carbon();

        $year = request('year') ?? $now->format('Y');
        $month = request('month') ?? $now->format('m');
        $day = request('day') ?? $now->format('d');

        $currentDay = Carbon::create($year, $month, $day);
        $yesterday = $currentDay->copy()->subDay();
        $tomorrow = $currentDay->copy()->addDay();

        $dateTitle = $currentDay->format('Y年n月j日');
        $dateLabel = $currentDay->format('Y/m/d');

        $attendances = Attendance::where('date', $currentDay)
            ->with('breakRecord', 'user')
            ->get();

        foreach ($attendances as $attendance) {
            $attendance->user_name = $attendance->user->name;
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
        return view('admin.attendance.index', compact('dateTitle', 'dateLabel', 'yesterday', 'tomorrow', 'attendances'));
    }

    public function show($id)
    {
        $attendance = Attendance::where('id', $id)
            ->with('breakRecord')
            ->first();

        $user_name = $attendance->user->name;
        $date = Carbon::parse($attendance->date)->isoFormat('YYYY年M月D日');

        $attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
        $attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');

        foreach ($attendance->breakRecord as $break) {
            $break->start_time = Carbon::parse($break->start_time)->format('H:i');
            $break->end_time = Carbon::parse($break->end_time)->format('H:i');
        }

        $approval = CorrectionRequest::where('approval', 0)
            ->where('attendance_id', $attendance->id)
            ->exists();
        return view('admin.attendance.show', compact('id', 'user_name', 'attendance', 'date', 'approval'));
    }

    public function correct($id, AttendanceRequest $request)
    {
        $attendance = Attendance::find($id);
        $attendance->update([
            'start_time' => $request->attendance_start_time,
            'end_time' => $request->attendance_end_time,
        ]);

        BreakRecord::where('attendance_id', $id)->delete();

        foreach ($request->break_start_time as $index => $start) {
            if ($start != null) {
                BreakRecord::create([
                    'attendance_id' => $id,
                    'start_time' => $start,
                    'end_time' => $request->break_end_time[$index],
                ]);
            }
        }

        CorrectionRequest::create([
            'attendance_id' => $id,
            'comment' => $request->comment,
            'approval' => '1',
            'approver_id' => auth()->id(),
        ]);

        return redirect("/admin/attendance/$id");
    }
}
