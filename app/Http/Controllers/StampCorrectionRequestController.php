<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\CorrectionRequest;
use App\Models\CorrectionRequestBreak;


class StampCorrectionRequestController extends Controller
{
    public function index()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->pluck('id');
        $pendings = CorrectionRequest::whereIn('attendance_id', $attendance)
            ->where('approval', 0)
            ->get();
        $approveds = CorrectionRequest::whereIn('attendance_id', $attendance)
            ->where('approval', 1)
            ->get();

        $approvalMap = [
            '0' => '承認待ち',
            '1' => '承認済み',
            '2' => '却下'
        ];

        foreach ($pendings as $pending) {
            $pending->approval = $approvalMap[$pending->approval];
            $pending->attendance->date = Carbon::parse($pending->attendance->date)->isoFormat('YYYY/MM/DD');
        }

        foreach ($approveds as $approved) {
            $approved->approval = $approvalMap[$approved->approval];
            $approved->attendance->date = Carbon::parse($approved->attendance->date)->isoFormat('YYYY/MM/DD');
        }

        return view('stamp_correction_request.index', compact('pendings', 'approveds'));
    }
}
