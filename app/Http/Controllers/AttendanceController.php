<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function store()
    {
        return view('attendance.create');
    }
}
