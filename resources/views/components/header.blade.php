    <nav class="navbar navbar-expand-md navbar-light p-1 shadow " style="background-color:#ffcb42">
        <a class="navbar-brand ml-4" href="{{ url('/') }}">
            <img src="{{asset('img/footer2.png')}}">
        </a>
    
            <!-- Right Side Of Navbar -->
            @guest
            <!-- Authentication Links -->
            <ul class="nav pull-right nav-prlls ml-auto command-list">
                <li class="nav-item command-btn">
                    <a class="nav-link btn-circle-3d btn-circle-3d-register" href="{{ route('register') }}">
                        <img src="{{asset('img/footer2.png')}}" class="nav-icon">
                    </a>
                    <p class="text-p">新規登録</p>
                </li>
                <li class="nav-item command-btn">
                    <a class="nav-link btn-circle-3d btn-circle-3d-login" href="{{ route('login') }}">
                        <img src="{{asset('img/loginbtn.png')}}" class="nav-icon">
                    </a>
                    <p class="text-p">ログイン</p>
                </li>
            </ul>
            @endguest
            
            @auth
            <!-- Authentication Links -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item">
                        <a class="nav-link" href="#">クエスト</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">スコアランキング</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">スキル習得</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">記録</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">アイテム</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>    
            @endauth
            
        
    </nav>