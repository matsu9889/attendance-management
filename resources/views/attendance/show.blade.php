@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendanceshow.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <form action="/attendance/detail/{{$id}}/correct" method="post">
            @csrf
            <h1 class="title">勤怠詳細</h1>
            <table class="table">
                <tr class="table-group">
                    <th class="table__header">名前</th>
                    <td class="table__description">{{$user->name}}</td>
                </tr>
                <tr>
                    <th class="table__header">日付</th>
                    <td class="table__description">{{$date}}</td>
                </tr>
                <tr>
                    <th class="table__header">出勤・退勤</th>
                    <td class="table__description"><input type="text" name="attendance_start_time" value="{{$attendance->start_time}}"></td>
                    <td>～</td>
                    <td class="table__description"><input type="text" name="attendance_end_time" value="{{$attendance->end_time}}"></td>
                </tr>
                <tr>
                    <td>
                        @if($errors->has('attendance_start_time') || $errors->has('attendance_end_time'))
                        <p>出勤時間もしくは退勤時間が不適切な値です</p>
                        @endif
                    </td>
                </tr>
                @foreach($attendance->breakRecord as $breakRecord)
                <tr>
                    <th class="table__header">休憩{{ $loop->iteration == 1 ? '' : $loop->iteration }}</th>
                    <td class="table__description"><input type="text" name="break_start_time[]" value="{{$breakRecord->start_time}}"></td>
                    <td>～</td>
                    <td class="table__description"><input type="text" name="break_end_time[]" value="{{$breakRecord->end_time}}"></td>
                </tr>
                <tr>
                    <td>
                        @if($errors->has('break_start_time.*') || $errors->has('break_end_time.*'))
                        <p>休憩時間が不適切な値です</p>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th class="table__header">休憩{{ $attendance->breakRecord->count() == 0 ? '' : $attendance->breakRecord->count()+1 }}</th>
                    <td class="table__description"><input type="text" name="break_start_time[]" value=""></td>
                    <td>～</td>
                    <td class="table__description"><input type="text" name="break_end_time[]" value=""></td>
                </tr>
                <tr>
                    <td>
                        @if($errors->has('break_start_time.*') || $errors->has('break_end_time.*'))
                        <p>休憩時間が不適切な値です</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table__header">備考</th>
                    <td class="table__description"><textarea name="comment" id=""></textarea></td>
                </tr>
                <tr>
                    <td>
                        @error('comment')
                        <p>{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
            </table>
            @if($approval == true)
            <p>*承認待ちのため修正はできません。</p>
            @else
            <button>修正</button>
            @endif
        </form>
    </div>
</div>

@endsection