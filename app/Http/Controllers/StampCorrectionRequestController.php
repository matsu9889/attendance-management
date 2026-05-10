<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $pending = CorrectionRequest::whereIn('attendance_id', $attendance)
            ->where('approval', 0)
            ->get();
        $approved = CorrectionRequest::whereIn('attendance_id', $attendance)
            ->where('approval', 1)
            ->get();

        return view('stamp_correction_request.index', compact('pending', 'approved'));
    }
}
