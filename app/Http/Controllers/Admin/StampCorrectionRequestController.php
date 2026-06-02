<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\CorrectionRequest;

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
        $year = Carbon::parse($attendance->date)->isoFormat('YYYY年');
        $date = Carbon::parse($attendance->date)->isoFormat('M月D日');

        $correction_request->start_time = Carbon::parse($correction_request->start_time)->format('H:i');
        $correction_request->end_time = Carbon::parse($correction_request->end_time)->format('H:i');

        foreach ($correction_request->breakRecords as $breakRecord) {
            $breakRecord->start_time = Carbon::parse($breakRecord->start_time)->format('H:i');
            $breakRecord->end_time = Carbon::parse($breakRecord->end_time)->format('H:i');
        }

        return view('admin.stamp_correction_request.edit', compact('id', 'correction_request', 'user_name', 'attendance', 'year', 'date',));
    }

    public function update($attendance_correct_request_id)
    {
        $correction_request = CorrectionRequest::with('breakRecords')
            ->find($attendance_correct_request_id);

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

        BreakRecord::where('attendance_id', $attendance_id)->delete();

        foreach ($correction_request->breakRecords as $correctionRequestBreakRecord) {
            BreakRecord::create([
                'attendance_id' => $attendance_id,
                'start_time' => $correctionRequestBreakRecord->start_time,
                'end_time' => $correctionRequestBreakRecord->end_time,
            ]);
        }
        return redirect('/stamp_correction_request/list');
    }
}
