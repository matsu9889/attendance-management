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
                <td class="table__description"></td>
            </tr>
            <tr>
                <th class="table__header">日付</th>
                <td class="table__description"></td>
            </tr>
            <tr>
                <th class="table__header">出勤・退勤</th>
                <td class="table__description"></td>
            </tr>
            <tr>
                <th class="table__header">休憩</th>
                <td class="table__description"></td>
            </tr>
            <tr>
                <th class="table__header">休憩２</th>
                <td class="table__description"></td>
            </tr>
            <tr>
                <th class="table__header">備考</th>
                <td class="table__description"></td>
            </tr>
        </table>
        <button>修正</button>
    </div>
</div>

@endsection