@guest
    <nav id="header" class="navbar navbar-light fixed-top shadow-sm" style="padding:0 clamp(0px,2vw,16px); background-color:#fff">
        <a class="navbar-brand" style="margin:0;" href="{{ route('web.index') }}">
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
        <ul class="nav text-right">
            <li class="nav-item text-center">
                <a class="nav-link mt-3" style="color:#219ddd;" href="{{ route('register') }}">
                    <i class="fas fa-plus" style="font-size:clamp(19px,4vw,28px);"></i>
                    <br>
                    <b style="font-size:clamp(10px,3vw,16px);">新規登録</b>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link mt-3" style="color:#ffcb42;" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt" style="font-size:clamp(19px,4vw,28px);"></i>
                    <br>
                    <b style="font-size:clamp(8px,3vw,16px);">ログイン</b>
                </a>
            </li>
        </ul>
    </nav>
@endguest
            
@auth
    <nav id="header" class="navbar navbar-light fixed-top shadow-sm" style="padding-bottom:0; background-color:#fff">
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
    </nav>
@endauth