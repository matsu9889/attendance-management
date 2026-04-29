@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<h1 class="title">勤怠一覧</h1>
<div class="month">
    <a class="month__link" href="">前月</a>
    <p>今月</p>
    <a class="month__link" href="">翌月</a>
</div>

<table class="table">
    <tr class="table__header">
        <th>日付</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>合計</th>
        <th>詳細</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr class="table__description">
        <td>{{$attendance->date}}</td>
        <td>{{$attendance->start_time}}</td>
        <td>{{$attendance->end_time}}</td>
        <td>{{$attendance->break_total}}</td>
        <td>{{$attendance->work_total}}</td>
        <td><a class="" href="">詳細</a></td>
    </tr>
    @endforeach
</table>

@endsection