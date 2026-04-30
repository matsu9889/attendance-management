@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">勤怠一覧</h1>
        <div class="month">
            <a class="month__link" href="">前月</a>
            <p>今月</p>
            <a class="month__link" href="">翌月</a>
        </div>

        <table class="table">
            <tr class="table__header-group">
                <th class="table__header">日付</th>
                <th class="table__header">出勤</th>
                <th class="table__header">退勤</th>
                <th class="table__header">休憩</th>
                <th class="table__header">合計</th>
                <th class="table__header">詳細</th>
            </tr>
            @foreach($attendances as $attendance)
            <tr class="table__description-group">
                <td class="table__description">{{$attendance->date}}</td>
                <td class="table__description">{{$attendance->start_time}}</td>
                <td class="table__description">{{$attendance->end_time}}</td>
                <td class="table__description">{{$attendance->break_total}}</td>
                <td class="table__description">{{$attendance->work_total}}</td>
                <td class="table__description"><a class="description-link" href="">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection