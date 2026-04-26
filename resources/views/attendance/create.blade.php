@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
<div>
    @if(session('work_status') == '出勤中')
    <p>出勤中</p>
    @elseif(session('work_status') == '休憩中')
    <p>休憩中</p>
    @elseif(session('work_status') == '退勤済')
    <p>退勤済</p>
    @else
    <p>勤務外</p>
    @endif
</div>
<div>
    <p>{{$date}}</p>
    <p>{{$time}}</p>
</div>
@if(session('work_status') == '出勤中')
<form action="/attendance/clock-out" method="post" class="">
    @csrf
    <button>退勤</button>
</form>
<form action="/attendance/break-in" method="post" class="">
    @csrf
    <button>休憩入</button>
</form>
@elseif(session('work_status') == '休憩中')
<form action="/attendance/break-out" method="post" class="">
    @csrf
    <button>休憩戻</button>
</form>
@elseif(session('work_status') == '退勤済')
<p>お疲れ様でした。</p>
@else
<form action="/attendance/clock-in" method="post" class="">
    @csrf
    <button>出勤</button>
</form>
@endif
@error('message')
<p>{{ $message }}</p>
@enderror



@endsection