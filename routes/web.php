<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampCorrectionRequestController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\StaffController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'create']);
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);
    Route::post('/attendance/break-in', [AttendanceController::class, 'breakIn']);
    Route::post('/attendance/break-out', [AttendanceController::class, 'breakOut']);
    Route::get('/attendance/list', [AttendanceController::class, 'index']);
    Route::get('/attendance/detail/{id}', [AttendanceController::class, 'show']);
    Route::post('/attendance/detail/{id}/correct', [AttendanceController::class, 'correct']);
    Route::get('/stamp_correction_request/list', [StampCorrectionRequestController::class, 'index']);
});

Route::get('/admin/login', [AuthController::class, 'index'])->middleware('guest');
Route::get('/admin/attendance/list', [AdminAttendanceController::class, 'index']);
Route::get('/admin/attendance/{id}', [AdminAttendanceController::class, 'show']);
Route::post('/admin/attendance/{id}/correct', [AdminAttendanceController::class, 'correct']);
Route::get('/admin/staff/list', [StaffController::class, 'index']);