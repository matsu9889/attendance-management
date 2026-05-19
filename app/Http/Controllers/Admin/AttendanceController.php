<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\CorrectionRequest;


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
}
