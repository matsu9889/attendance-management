<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function create()
    {
        $now = new Carbon();

        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');
        return view('attendance.create', compact('date', 'time'));
    }

    public function clockIn(Request $request)
    {
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');
        $request->session()->put('work_status', '出勤中');
        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $now->format('Y-m-d'),
            'start_time' => $now->format('H:i'),
            'end_time' => NULL,
        ]);
        return view('attendance.create', compact('date', 'time'));
    }

    public function clockOut(Request $request)
    {
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');
        $request->session()->put('work_status', '退勤済');

        return view('attendance.create', compact('date', 'time'));
    }

    public function breakIn(Request $request)
    {
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

        $request->session()->put('work_status', '休憩中');
        return view('attendance.create', compact('date', 'time'));
    }

    public function breakOut(Request $request)
    {
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

        $request->session()->put('work_status', '出勤中');
        return view('attendance.create', compact('date', 'time'));
    }
}
