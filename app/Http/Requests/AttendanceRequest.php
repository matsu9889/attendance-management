<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attendance_start_time' => 'required|date_format:H:i:s|before:attendance_end_time',
            'attendance_end_time' => 'required|date_format:H:i:s|after:attendance_start_time',
            'break_start_time.*' => 'after:attendance_start_time|before:attendance_end_time',
            'break_end_time.*' => 'before:attendance_end_time',
            'comment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'attendance_start_time.required' => '出勤時間を記入してください',
            'attendance_start_time.before' => '出勤時間もしくは退勤時間が不適切な値です',
            'attendance_end_time.required' => '退勤時間を記入してください',
            'attendance_end_time.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'break_start_time.*.after' => '休憩時間が不適切な値です',
            'break_start_time.*.before' => '休憩時間が不適切な値です',
            'break_end_time.*.before' => '休憩時間もしくは退勤時間が不適切な値です',
            'comment.required' => '備考を記入してください'
        ];
    }
}
