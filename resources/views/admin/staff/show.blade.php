@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">{{$user->name}}さんの勤怠</h1>
        <div class="month">
            <a class="month__link" href="/admin/attendance/staff/{{$user->id}}?year={{ $subMonth->format('Y') }}&month={{ $subMonth->format('m') }}">
                <img class="left-arrow" src="{{ asset('images/矢印.png') }}" alt="矢印">
                前月
            </a>
            <div>
                <img class="calendar" src="{{ asset('images/カレンダー.png') }}" alt="カレンダー">
                <p class="this-month">{{$thisMonth}}</p>
            </div>
            <a class="month__link" href="/admin/attendance/staff/{{$user->id}}?year={{ $addMonth->format('Y') }}&month={{ $addMonth->format('m') }}">
                翌月
                <img class="right-arrow" src="{{ asset('images/矢印.png') }}" alt="矢印">
            </a>
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
            @foreach($days as $day)
            @php $attendance = $attendances->get($day['key']); @endphp
            <tr class="table__description-group">
                <td class="table__description">{{$day['label']}}</td>
                <td class="table__description">{{ $attendance ? $attendance->start_time : '' }}</td>
                <td class="table__description">{{ $attendance ? $attendance->end_time : '' }}</td>
                <td class="table__description">{{ $attendance ? $attendance->break_total : '' }}</td>
                <td class="table__description">{{ $attendance ? $attendance->work_total : '' }}</td>
                <td class="table__description">
                    @if($attendance)
                    <a class="description-link" href="/admin/attendance/{{$attendance->id}}">詳細</a>
                    @else
                    <a class="description-link" href="">詳細</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection