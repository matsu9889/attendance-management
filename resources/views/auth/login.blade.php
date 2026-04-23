@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<form action="/login" method="post" class="form">
    @csrf
    <h1 class="form__title">ログイン</h1>
    <div class="form__group">
        <label class="form__label" for="email">メールアドレス</label>
        <input class="form__input" name="email" id="email" type="email" value="{{ old('email') }}">
        <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form__group">
        <label class="form__label" for="password">パスワード</label>
        <input class="form__input" name="password" id="password" type="password">
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>
    <button class="form__button">ログインする</button>
    <a href="/register" class="form__link">会員登録はこちら</a>
</form>
@endsection