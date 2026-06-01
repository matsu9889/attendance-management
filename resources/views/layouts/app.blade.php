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
        <div class="header__logo">
            <a href="/attendance">
                <img class="header__img" src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>
        </div>

        <ul class="header-nav">
            @auth
            @if(Auth::user()->role == 0)
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
            @elseif(Auth::user()->role == 1)
            <li class="header-nav__item">
                <a class="header-nav__link" href="/admin/attendance/list">勤怠一覧</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/admin/staff/list">スタッフ一覧</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/stamp_correction_request/list">申請一覧</a>
            </li>
            <li class="header-nav__item">
                <form action="/logout" method="post">
                    @csrf
                    <button class="header-nav__button">ログアウト</button>
                </form>
            </li>
            @endif
            @else
            <li>
                <a class="header-nav__button" href="/login">ログイン</a>
            </li>
            @endauth
        </ul>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>