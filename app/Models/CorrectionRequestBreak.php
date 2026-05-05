<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectionRequestBreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'correction_request_id',
        'start_time',
        'end_time'
    ];

    public function attendance()
    {
        return $this->belongsTo(CorrectionRequest::class);
    }
}
