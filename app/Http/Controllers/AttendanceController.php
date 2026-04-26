<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;

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

    // 出勤登録機能
    public function clockIn(Request $request)
    {
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

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
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

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
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

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
        $now = new Carbon();
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $date = $now->format('Y年m月d日');
        $date = $date . '(' . $weekday[$now->dayOfWeek] . ')';
        $time = $now->format('H:i');

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

    public function index()
    {
        return view('attendance.index');
    }
}
