@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
<h1>勤怠一覧</h1>
<div>
    <a href="">前月</a>
    <p>今月</p>
    <a href="">翌月</a>
</div>

<table>
    <tr>
        <th>日付</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>合計</th>
        <th>詳細</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr>
        <td>{{$attendance->date}}</td>
        <td>{{$attendance->start_time}}</td>
        <td>{{$attendance->end_time}}</td>
        <td>{{$attendance->break_total}}</td>
        <td>{{$attendance->work_total}}</td>
        <td></td>
    </tr>
    @endforeach
</table>

@endsection