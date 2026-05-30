@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-show.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">勤怠詳細</h1>
        <form action="/admin/stamp_correction_request/approve/{{$id}}" method="post">
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
                        <p class="time">{{$correction_request->start_time}}</p>
                        <span>～</span>
                        <p class="time">{{$correction_request->end_time}}</p>
                    </div>
                </div>
                @foreach($correction_request->breakRecords as $breakRecord)
                <div class="label-group">
                    <label class="label" for="break">休憩{{ $loop->iteration == 1 ? '' : $loop->iteration }}</label>
                    <div class="input-group">
                        <p class="time">{{$breakRecord->start_time}}</p>
                        <span>～</span>
                        <p class="time">{{$breakRecord->end_time}}</p>
                    </div>
                </div>
                @endforeach
                <div class="label-group">
                    <label class="label" for="break">休憩{{ $attendance->breakRecord->count() == 0 ? '' : $attendance->breakRecord->count()+1 }}</label>
                    <div class="input-group">
                        <p></p>
                        <p></p>
                    </div>
                </div>
                <div class="label-group">
                    <label class="label" for="comment">備考</label>
                    <div class="input-group">
                        <p class="time">{{$correction_request->comment}}</p>
                    </div>
                </div>
            </div>
            <div class="button-area">
                <button class="button">承認</button>
            </div>
        </form>
    </div>
</div>

@endsection