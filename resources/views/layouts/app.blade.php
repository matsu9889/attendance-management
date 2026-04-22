<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech 勤怠管理アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header_logo">
            <a href="/attendance">
                <img class="header_img" src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>
        </div>

        <ul class="header-nav">
            @auth
            <li class="header-nav__item">
                <a class="header-nav__link" href="/attendance">勤怠</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/attendance/list">勤怠一覧</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/stamp_correction_request/list">申請</a>
            </li>
            <li class="header-nav__item">
                <form action="/logout" method="post">
                    @csrf
                    <button class="header-nav__button">ログアウト</button>
                </form>
            </li>
            @else
            <li>
                <a href="/login">
                    <button class="header-nav__button">ログイン</button>
                </a>
            </li>
            @endauth
        </ul>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>