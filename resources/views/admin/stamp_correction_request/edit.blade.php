@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendanceshow.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">勤怠詳細</h1>
        <form action="/" method="post">
            @csrf
            <div class="form">
                <div class="label-group">
                    <label class="label" for="name">名前</label>
                    <div class="text">{{$user_name}}</div>
                </div>
                <div class="label-group">
                    <label class="label" for="date">日付</label>
                    <div class="text">{{$date}}</div>
                </div>
                <div class="label-group">
                    <label class="label" for="attendance">出勤・退勤</label>
                    <div class="input-group">
                        <div>{{$attendance->start_time}}</div>
                        <span>～</span>
                        <div>{{$attendance->end_time}}</div>
                    </div>
                </div>
                @foreach($attendance->breakRecord as $breakRecord)
                <div class="label-group">
                    <label class="label" for="break">休憩{{ $loop->iteration == 1 ? '' : $loop->iteration }}</label>
                    <div class="input-group">{{$breakRecord->start_time}}</div>
                    <span>～</span>
                    <div>{{$breakRecord->end_time}}</div>
                </div>
                @endforeach
                <div class="label-group">
                    <label class="label" for="comment">備考</label>
                    <div class="input-group">{{textarea}}</div>
                </div>
            </div>
            <div class="button-area">
                <button class="button">承認</button>
            </div>
        </form>
    </div>
</div>

@endsection