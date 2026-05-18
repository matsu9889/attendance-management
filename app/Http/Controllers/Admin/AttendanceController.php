<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;


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

        $date = $currentDay->format('Y/m/d');

        $attendances = Attendance::where('date', $date)
            ->with('breakRecord')
            ->get();

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
        return view('admin.attendance.index', compact('date', 'yesterday', 'tomorrow', 'attendances'));
    }
}
