@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<form action="/register" method="post" class="">
    @csrf
    <h1>会員登録</h1>
    <div>
        <label for="name">名前</label>
        <input name="name" id="name" type="text" value="{{ old('name') }}">
        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div>
        <label for="email">メールアドレス</label>
        <input name="email" id="email" type="email" value="{{ old('email') }}">
        <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div>
        <label for="password">パスワード</label>
        <input name="password" id="password" type="password" value="{{ old('password') }}">
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div>
        <label for="password_confirmation">パスワード確認</label>
        <input name="password_confirmation" id="password_confirmation" type="password">
    </div>
    <button>登録する</button>
    <a href="/login">ログインはこちら</a>
</form>
@endsection