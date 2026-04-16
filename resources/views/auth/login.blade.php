<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/login" method="post" class="">
        @csrf
        <h1>ログイン</h1>
        <div>
            <label for="email">メールアドレス</label>
            <input name="email" id="email" type="email" value="{{ old('email') }}">
        </div>
        <div>
            <label for="password">パスワード</label>
            <input name="password" id="password" type="password">
        </div>
        <button>ログインする</button>
        <a href="/register">会員登録はこちら</a>
    </form>
</body>

</html>