@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list-style.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">{{$dateTitle}}の勤怠</h1>
    <div class="month">
        <a class="month__link" href="/admin/attendance/list?year={{ $yesterday->format('Y') }}&month={{ $yesterday->format('m') }}&day={{ $yesterday->format('d') }}">
            <img class="month__arrow--left" src="{{ asset('images/矢印.png') }}" alt="矢印">
            前日
        </a>
        <div>
            <img class="month__calendar" src="{{ asset('images/カレンダー.png') }}" alt="カレンダー">
            <p class="month__label">{{$dateLabel}}</p>
        </div>
        <a class="month__link" href="/admin/attendance/list?year={{ $tomorrow->format('Y') }}&month={{ $tomorrow->format('m') }}&day={{ $tomorrow->format('d') }}">
            翌日
            <img class="month__arrow--right" src="{{ asset('images/矢印.png') }}" alt="矢印">
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
        @foreach($users as $user)
        <tr class="table__description-group">
            <td class="table__description">{{$user->name}}</td>
            <td class="table__description">{{$user->start_time}}</td>
            <td class="table__description">{{$user->end_time}}</td>
            <td class="table__description">{{$user->break_total}}</td>
            <td class="table__description">{{$user->work_total}}</td>
            <td class="table__description">
                @if($user->attendance_id)
                <a class="description-link" href="/admin/attendance/{{$user->attendance_id}}">詳細</a>
                @else
                <a class="description-link" href="">詳細</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection