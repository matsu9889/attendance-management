<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/register" method="post" class="">
        @csrf
        <h1>会員登録</h1>
        <div>
            <label for="name">名前</label>
            <input name="name" id="name" type="text" value="{{ old('name') }}">
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input name="email" id="email" type="email" value="{{ old('email') }}">
        </div>
        <div>
            <label for="password">パスワード</label>
            <input name="password" id="password" type="password" value="{{ old('password') }}">
        </div>
        <div>
            <label for="password_confirmation">パスワード確認</label>
            <input name="password_confirmation" id="password_confirmation" type="password">
        </div>
        <button>登録する</button>
        <a href="/login">ログインはこちら</a>
    </form>
</body>

</html>