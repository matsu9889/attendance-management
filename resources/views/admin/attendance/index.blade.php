@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">申請一覧</h1>
        <div class="month">
            <a class="month__link" href="">
                <img class="left-arrow" src="{{ asset('images/矢印.png') }}" alt="矢印">
                前日
            </a>
            <div>
                <img class="calendar" src="{{ asset('images/カレンダー.png') }}" alt="カレンダー">
                <p class="this-month">月日</p>
            </div>
            <a class="month__link" href="">
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
            <tr class="table__description-group">
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description">
                    <a class="description-link" href="">詳細</a>
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection