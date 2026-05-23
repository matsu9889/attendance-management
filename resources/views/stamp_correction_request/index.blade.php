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
                <td>
                    @if(auth()->user()->role === 0)
                    <a class="description-link" href="/attendance/detail/{{$pending->id}}">詳細</a>
                    @elseif(auth()->user()->role === 1)
                    <a class="description-link" href="/admin/stamp_correction_request/approve/{{$pending->id}}">詳細</a>
                    @endif
                </td>
            </tr>
            @endforeach
            <!-- 承認済み -->
            @foreach($approveds as $approved)
            <tr class="table__description-group">
                <td class="table__description">{{$approved->approval}}</td>
                <td class="table__description">{{$approved->attendance->user->name}}</td>
                <td class="table__description">{{$approved->attendance->date}}</td>
                <td class="table__description">{{$approved->comment}}</td>
                <td class="table__description">{{$approved->created_at->isoFormat('YYYY/MM/DD')}}</td>
                <td>
                    @if(auth()->user()->role === 0)
                    <a class="description-link" href="/attendance/detail/{{$approved->id}}">詳細</a>
                    @elseif(auth()->user()->role === 1)
                    <a class="description-link" href="/admin/stamp_correction_request/approve/{{$approved->id}}">詳細</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection