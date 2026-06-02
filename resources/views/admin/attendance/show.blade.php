@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-show.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">勤怠詳細</h1>
    <form action="/admin/attendance/{{$id}}/correct" method="post">
        @csrf
        <div class="form">
            <div class="label-group">
                <label class="label" for="name">名前</label>
                <div class="text">{{$user_name}}</div>
            </div>
            <div class="label-group">
                <label class="label" for="date">日付</label>
                <div class="input-group">
                    <div class="date">{{$year}}</div>
                    <span>&emsp;</span>
                    <div class="date">{{$date}}</div>
                </div>
            </div>
            <div class="label-group">
                <label class="label" for="attendance">出勤・退勤</label>
                <div class="input-group">
                    <div>
                        <input class="input-time" type="text" name="attendance_start_time" value="{{$attendance->start_time}}">
                    </div>
                    <span>～</span>
                    <div>
                        <input class="input-time" type="text" name="attendance_end_time" value="{{$attendance->end_time}}">
                    </div>
                    <div class="input-error">
                        @if($errors->has('attendance_start_time') || $errors->has('attendance_end_time'))
                        <p>出勤時間もしくは退勤時間が不適切な値です</p>
                        @endif
                    </div>
                </div>
            </div>
            @foreach($attendance->breakRecord as $breakRecord)
            <div class="label-group">
                <label class="label" for="break">休憩{{ $loop->iteration == 1 ? '' : $loop->iteration }}</label>
                <div class="input-group">
                    <input class="input-time" type="text" name="break_start_time[]" value="{{$breakRecord->start_time}}">
                    <span>～</span>
                    <input class="input-time" type="text" name="break_end_time[]" value="{{$breakRecord->end_time}}">
                    <div class="input-error">
                        @if($errors->has('break_start_time.*'))
                        <p>休憩時間が不適切な値です</p>
                        @endif
                        @if($errors->has('break_end_time.*'))
                        <p>休憩時間もしくは退勤時間が不適切な値です</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <div class="label-group">
                <label class="label" for="break">休憩{{ $attendance->breakRecord->count() == 0 ? '' : $attendance->breakRecord->count()+1 }}</label>
                <div class="input-group">
                    <input class="input-time" type="text" name="break_start_time[]" value="">
                    <span>～</span>
                    <input class="input-time" type="text" name="break_end_time[]" value="">
                    <div class="input-error">
                        @if($errors->has('break_start_time.*'))
                        <p>休憩時間が不適切な値です</p>
                        @endif
                        @if($errors->has('break_end_time.*'))
                        <p>休憩時間もしくは退勤時間が不適切な値です</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label class="label" for="comment">備考</label>
                <div class="input-group">
                    <textarea class="textarea" name="comment" id="comment">{{ old('comment') }}</textarea>
                    <div class="input-error">
                        @error('comment')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        @if($approval == true)
        <p class="message">*承認待ちのため修正はできません。</p>
        @else
        <div class="button-area">
            <button class="button">修正</button>
        </div>
        @endif
    </form>
</div>

@endsection