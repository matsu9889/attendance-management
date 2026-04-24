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

<?php
$date = new DateTime();
echo $date->format('Y-m-d');
echo $date->format('H:i')
?>
<p>日付</p>

<p>時間</p>
<button>出勤</button>
@endsection