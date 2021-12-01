<nav id="header" class="navbar navbar-light fixed-top shadow-sm" style="padding-bottom:0; background-color:#fff">

    <!-- Right Side Of Navbar -->
    @auth
        <div class="w-100" style="border-bottom:1px solid #e0e0e0;">
            <a class="navbar-brand" href="{{ route('mains.index') }}">
                <div class="container" style="padding-left:1vw;">
                    <div class="row justify-content-center d-flex align-items-center">
                        <div class="col" style="padding-right:4px;">
                            <img src="{{asset('img/header.png')}}" style="height:clamp(47px,9vw,55px); width:clamp(30px,5vw,35px)">
                        </div>
                        <div class="col text-left font-dot" style="padding-left:0;">
                            <b style="font-size:clamp(12px,4vw,20px);">ダイエット</b>
                            <br>
                            <b style="font-size:clamp(12px,4vw,20px);">ファイター</b>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Authentication Links -->
            <button class="navbar-toggler float-right mt-3 mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link_arrow_nav link_arrow_nav--right" href="#" id="navbarDropdownSkill" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-hat-wizard fa-lg mr-2" style="color:#ffcb42;"></i>
                            スキル
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownSkill">
                            <a class="dropdown-item" href="{{ route('skills.create') }}">スキル習得・強化</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('skills.index') }}">スキル一覧</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link_arrow_nav link_arrow_nav--right" href="#" id="navbarDropdownItem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-flask fa-lg mr-2" style="color:#ffcb42;"></i>
                            アイテム
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownItem">
                            <a class="dropdown-item" href="{{ route('items.create') }}">アイテム購入</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('items.index') }}">アイテム一覧</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_arrow_nav link_arrow_nav--right" href="{{ route('records.latest') }}">
                            <i class="fas fa-paste fa-lg mr-2" style="color:#ffcb42;"></i>
                            記録
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_arrow_nav link_arrow_nav--right" href="{{ route('userInformations.index') }}">
                            <i class="fas fa-users-cog fa-lg" style="color:#ffcb42;"></i>
                            ユーザー情報
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_arrow_nav link_arrow_nav--right" style="border-bottom:3px solid #66cdaa;" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-lg mr-1" style="color:#ffcb42;"></i>
                            ログアウト
                        </a>
            
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="nav nav-pills text-center w-100 mt-1">
            <li class="nav-item" style="width:33%;">
                <a class="nav-link" style="color:#999999; display:inline-block; width:90%; white-space: nowrap; font-size:clamp(10px,3vw,14px);" href="{{ route('mains.index') }}">
                    <i class="fas fa-home fa-2x" style="color:#999999;"></i>
                    <br>
                    <b>ホーム</b>
                </a>
            </li>
            <li class="nav-item" style="width:33%;">
                <a class="nav-link" style="color:#999999; display:inline-block; width:90%; white-space: nowrap; font-size:clamp(10px,3vw,14px);" href="{{ route('quests.create') }}">
                    <i class="fas fa-gem fa-2x" style="color:#999999;"></i>
                    <br>
                    <b>クエスト</b>
                </a>
            </li>
            <li class="nav-item" style="width:33%;">
                <a class="nav-link" style="color:#ffcb42; display:inline-block; width:90%; white-space: nowrap; font-size:clamp(10px,3vw,14px);" href="{{ route('rankings.index') }}">
                    <i class="fas fa-crown fa-2x" style="color:#ffcb42;"></i>
                    <br>
                    <b>ランキング</b>
                </a>
            </li>
        </ul>
    @endauth
</nav>    