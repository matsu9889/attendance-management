<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\CorrectionRequest;



class StampCorrectionRequestController extends Controller
{
    public function edit($id)
    {
        $correction_request = CorrectionRequest::find($id);
        $attendance_id = $correction_request->attendance_id;
        $attendance = Attendance::where('id', $attendance_id)
            ->with('breakRecord')
            ->first();

        $user_name = $attendance->user->name;
        $date = Carbon::parse($attendance->date)->isoFormat('YYYY年MM月DD日');

        $attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
        $attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');

        foreach ($attendance->breakRecord as $break) {
            $break->start_time = Carbon::parse($break->start_time)->format('H:i');
            $break->end_time = Carbon::parse($break->end_time)->format('H:i');
        }

        $approval = CorrectionRequest::where('approval', 0)
            ->where('attendance_id', $attendance->id)
            ->first();

        return view('admin.stamp_correction_request.edit', compact('id', 'user_name', 'attendance', 'date', 'approval'));
    }
}
