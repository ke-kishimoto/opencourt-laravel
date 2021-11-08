<header role="banner">
    <!-- ハンバーガーボタン -->
    <button type="button" class="drawer-toggle drawer-hamburger">
        <span class="sr-only">toggle navigation</span>
        <span class="drawer-hamburger-icon"></span>
    </button>
    <!-- ナビゲーションの中身 -->
    <nav class="drawer-nav" role="navigation">
        <ul class="drawer-menu">
            @if(session('user') && session('user')->role_level < 3)
            <li ><a class="drawer-brand" href="#">管理者メニュー</a></li>
            <li ><a class="drawer-menu-item" href="config/1">システム設定</a></li>
            <li ><a class="drawer-menu-item" href="eventTemplate">テンプレート設定</a></li>
            <li ><a class="drawer-menu-item" href="/admin/userList">ユーザーリスト</a></li>
            <li ><a class="drawer-menu-item" href="/admin/inquiryList">問い合わせ管理</a></li>
            <li ><a class="drawer-menu-item" href="/admin/notice">お知らせ登録</a></li>
            <li ><a class="drawer-menu-item" href="/sales/index">売上管理</a></li>
            <li ><a class="drawer-menu-item" href="/admin/segmentDelivery">セグメント配信</a></li>
            @endif
            <li ><a class="drawer-brand" href="#">ユーザーメニュー</a></li>
            @if(session('user'))
            <li ><a class="drawer-menu-item" href="/user/participatingEventList">参加イベント一覧</a></li>
            <li ><a class="drawer-menu-item" href="/participant/eventBatchRegist">イベント一括参加</a></li>
            <li><a class="drawer-menu-item" href="/help/inquiry">お問い合わせ</a></li>
            <li><a class="drawer-menu-item" href="/help/troubleReport">障害報告・要望</a></li>
            <li ><a class="drawer-menu-item" href="">アカウント情報</a></li>
            <li ><a class="drawer-menu-item" href="/user/signout">ログアウト</a></li>
            @else
            <li ><a class="drawer-menu-item" href="newAccount">新規登録</a></li>
            <li ><a class="drawer-menu-item" href="login">ログイン</a></li>
            @endif
        </ul>
    </nav>
    <div class="system-header">
        <div class="dummy">
            user_name
        </div>
        <div class="system-name">
            <a class="logo" href="/"> systemTitle </a>
        </div>
        <div class="user-name">
            <span> user_name さん</span>
            <span class="participant-header-menu">
                @if(session('user'))
                <a class="btn btn-sm btn-outline-dark" href="'/user/edit" role="button" style="margin-right:5px;">アカウント情報</a>
                <a class="btn btn-sm btn-outline-dark" href="logout" role="button">ログアウト</a>
                @else
                <a class="btn btn-sm btn-outline-dark" href="newAccount" role="button" style="margin-right:5px;">新規登録</a>
                <a class="btn btn-sm btn-outline-dark" href="login" role="button">ログイン</a>
                @endif
            </span>
        </div>
    </div>
</header>