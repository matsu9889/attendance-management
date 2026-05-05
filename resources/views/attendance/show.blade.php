@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendanceshow.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">勤怠詳細</h1>
        <table class="table">
            <tr class="table-group">
                <th class="table__header">名前</th>
                <td class="table__description">{{$user->name}}</td>
            </tr>
            <tr>
                <th class="table__header">日付</th>
                <td class="table__description">{{$date}}</td>
            </tr>
            <tr>
                <th class="table__header">出勤・退勤</th>
                <td class="table__description"><input type="text" value="{{$attendance->start_time}}"></td>
                <td>～</td>
                <td class="table__description"><input type="text" value="{{$attendance->end_time}}"></td>
            </tr>
            @foreach($attendance->breakRecord as $breakRecord)
            <tr>
                <th class="table__header">休憩{{ $loop->iteration == 1 ? '' : $loop->iteration }}</th>
                <td class="table__description"><input type="text" value="{{$breakRecord->start_time}}"></td>
                <td>～</td>
                <td class="table__description"><input type="text" value="{{$breakRecord->end_time}}"></td>
            </tr>
            @endforeach
            <tr>
                <th class="table__header">休憩{{ $attendance->breakRecord->count() == 0 ? '' : $attendance->breakRecord->count()+1 }}</th>
                <td class="table__description"><input type="text" value=""></td>
                <td>～</td>
                <td class="table__description"><input type="text" value=""></td>
            </tr>
            <tr>
                <th class="table__header">備考</th>
                <td class="table__description"><textarea name="" id=""></textarea></td>
            </tr>
        </table>
        <button>修正</button>
    </div>
</div>

@endsection