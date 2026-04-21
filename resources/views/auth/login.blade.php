@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<form action="/login" method="post" class="">
    @csrf
    <h1>ログイン</h1>
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
        <input name="password" id="password" type="password">
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>
    <button>ログインする</button>
    <a href="/register">会員登録はこちら</a>
</form>
@endsection