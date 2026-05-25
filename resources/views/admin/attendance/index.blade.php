@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">{{$dateTitle}}の勤怠</h1>
    <div class="month">
        <a class="month__link" href="/admin/attendance/list?year={{ $yesterday->format('Y') }}&month={{ $yesterday->format('m') }}&day={{ $yesterday->format('d') }}">
            <img class="left-arrow" src="{{ asset('images/矢印.png') }}" alt="矢印">
            前日
        </a>
        <div>
            <img class="calendar" src="{{ asset('images/カレンダー.png') }}" alt="カレンダー">
            <p class="this-month">{{$dateLabel}}</p>
        </div>
        <a class="month__link" href="/admin/attendance/list?year={{ $tomorrow->format('Y') }}&month={{ $tomorrow->format('m') }}&day={{ $tomorrow->format('d') }}">
            翌日
            <img class="right-arrow" src="{{ asset('images/矢印.png') }}" alt="矢印">
        </a>
    </div>

    <table class="table">
        <tr class="table__header-group">
            <th class="table__header">名前</th>
            <th class="table__header">出勤</th>
            <th class="table__header">退勤</th>
            <th class="table__header">休憩</th>
            <th class="table__header">合計</th>
            <th class="table__header">詳細</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr class="table__description-group">
            <td class="table__description">{{$attendance->user_name}}</td>
            <td class="table__description">{{$attendance->start_time}}</td>
            <td class="table__description">{{$attendance->end_time}}</td>
            <td class="table__description">{{$attendance->break_total}}</td>
            <td class="table__description">{{$attendance->work_total}}</td>
            <td class="table__description">
                <a class="description-link" href="/admin/attendance/{{$attendance->id}}">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection