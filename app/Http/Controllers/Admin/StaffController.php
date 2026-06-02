<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::where('role', 0)
            ->get();

        return view('admin.staff.index', compact('users'));
    }

    public function show($id)
    {
        $now = new Carbon();
        $year = request('year') ?? $now->format('Y');
        $month = request('month') ?? $now->format('m');
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

        $user = User::find($id);

        $attendances = Attendance::where('user_id', $id)
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
        return view('admin.staff.show', compact('user','attendances', 'days', 'thisMonth', 'subMonth', 'addMonth'));
    }
}
