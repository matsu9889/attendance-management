@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendancelist.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h1 class="title">スタッフ一覧</h1>
        <table class="table">
            <tr class="table__header-group">
                <th class="table__header">名前</th>
                <th class="table__header">メールアドレス</th>
                <th class="table__header">月次勤怠</th>
            </tr>
            @foreach($users as $user)
            <tr class="table__description-group">
                <td class="table__description">{{$user->name}}</td>
                <td class="table__description">{{$user->email}}</td>
                <td class="table__description">
                    <a class="description-link" href="/admin/attendance/staff/{id}">詳細</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection