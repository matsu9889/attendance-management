@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div>
        @if(session('work_status') == '出勤中')
        <p class="status">出勤中</p>
        @elseif(session('work_status') == '休憩中')
        <p class="status">休憩中</p>
        @elseif(session('work_status') == '退勤済')
        <p class="status">退勤済</p>
        @else
        <p class="status">勤務外</p>
        @endif
    </div>
    <div>
        <p class="date">{{$date}}</p>
        <p class="time">{{$time}}</p>
    </div>
    <div class="button-group">
        @if(session('work_status') == '出勤中')
        <form action="/attendance/clock-out" method="post">
            @csrf
            <button class="button black">退勤</button>
        </form>
        <form action="/attendance/break-in" method="post">
            @csrf
            <button class="button">休憩入</button>
        </form>
        @elseif(session('work_status') == '休憩中')
        <form action="/attendance/break-out" method="post">
            @csrf
            <button class="button">休憩戻</button>
        </form>
        @elseif(session('work_status') == '退勤済')
        <p class="text">お疲れ様でした。</p>
        @else
        <form action="/attendance/clock-in" method="post">
            @csrf
            <button class="button black">出勤</button>
        </form>
        @endif
    </div>
    @error('message')
    <p>{{ $message }}</p>
    @enderror
</div>

@endsection