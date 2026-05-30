<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\CorrectionRequest;
use App\Models\CorrectionRequestBreak;

class StampCorrectionRequestController extends Controller
{
    public function edit($id)
    {
        $correction_request = CorrectionRequest::with('breakRecords')
            ->find($id);

        $attendance_id = $correction_request->attendance_id;
        $attendance = Attendance::where('id', $attendance_id)
            ->with('breakRecord')
            ->first();

        $user_name = $attendance->user->name;
        $date = Carbon::parse($attendance->date)->isoFormat('YYYY年MM月DD日');

        $correction_request->start_time = Carbon::parse($correction_request->start_time)->format('H:i');
        $correction_request->end_time = Carbon::parse($correction_request->end_time)->format('H:i');

        foreach ($correction_request->breakRecords as $breakRecord) {
            $breakRecord->start_time = Carbon::parse($breakRecord->start_time)->format('H:i');
            $breakRecord->end_time = Carbon::parse($breakRecord->end_time)->format('H:i');
        }

        return view('admin.stamp_correction_request.edit', compact('id', 'correction_request', 'user_name', 'attendance', 'date',));
    }

    public function update($attendance_correct_request_id)
    {
        $correction_request = CorrectionRequest::with('breakRecords')
        ->find($attendance_correct_request_id);
        dd($correction_request);
        
        $correction_request->update([
            'approval' => '1'
        ]);

        $attendance_id = $correction_request->attendance_id;
        if ($correction_request->start_time !== null) {
            Attendance::where('id', $attendance_id)
            ->update([
                'start_time' => $correction_request->start_time,
                'end_time' => $correction_request->end_time
            ]);
        }

        $breakRecord = breakRecord::where('attendance_id',$attendance_id);
        dd($breakRecord);

        foreach ($correction_request->breakRecords as $correctionBreakRecordd) { //休憩修正テーブル
            BreakRecord::where('attendance_id', $attendance_id)
                ->where('correction_request_id', $correction_request->id)
                ->update([
                    'start_time' => $breakRecord->start_time,
                    'end_time' => $breakRecord->end_time
                ]);
        }

        return redirect('/stamp_correction_request/list');
    }
}
