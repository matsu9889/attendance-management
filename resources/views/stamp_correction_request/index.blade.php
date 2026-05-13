@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">申請一覧</h1>
        <div class="">
            <p>承認待ち</p>
            <p>承認済み</p>
        </div>

        <table class="table">
            <tr class="table__header-group">
                <th class="table__header">状態</th>
                <th class="table__header">名前</th>
                <th class="table__header">対象日時</th>
                <th class="table__header">申請理由</th>
                <th class="table__header">申請日時</th>
                <th class="table__header">詳細</th>
            </tr>
            <!-- 承認待ち -->
            @foreach($pendings as $pending)
            <tr class="table__description-group">
                <td class="table__description">{{$pending->approval}}</td>
                <td class="table__description">{{$pending->attendance->user->name}}</td>
                <td class="table__description">{{$pending->attendance->date}}</td>
                <td class="table__description">{{$pending->comment}}</td>
                <td class="table__description">{{$pending->created_at->isoFormat('YYYY/MM/DD')}}</td>
                <td><a class="description-link" href="/attendance/detail/{{$pending->id}}">詳細</a></td>
            </tr>
            @endforeach
            <!-- 承認済み -->
            <tr class="table__description-group">
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td class="table__description"></td>
                <td><a class="description-link" href="">詳細</a></td>
            </tr>
        </table>
    </div>
</div>

@endsection