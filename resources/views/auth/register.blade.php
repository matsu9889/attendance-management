@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<form action="/register" method="post" class="form">
    @csrf
    <h1 class="form__title">会員登録</h1>
    <div class="form__group">
        <label class="form__label" for="name">名前</label>
        <input class="form__input" name="name" id="name" type="text" value="{{ old('name') }}">
        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
    </div>
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
        <input class="form__input" name="password" id="password" type="password" value="{{ old('password') }}">
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form__group">
        <label class="form__label" for="password_confirmation">パスワード確認</label>
        <input class="form__input" name="password_confirmation" id="password_confirmation" type="password">
    </div>
    <button class="form__button">登録する</button>
    <a href="/login" class="form__link">ログインはこちら</a>
</form>
@endsection