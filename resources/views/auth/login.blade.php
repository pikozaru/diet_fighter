@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mx-auto text-center under mt-4 mb-4">ログイン</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" class="h-50 form-control @error('email') is-invalid @enderror input-text mt-5 mb-5" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">
                    <input id="password" type="password" class="form-control @error('email') is-invalid @enderror input-text mt-5 mb-5" name="password" required autocomplete="current-password" autofocus placeholder="パスワード">
                    
                    @error('email')
                        <span class="invalid-feedback">
                            <strong>メールアドレス、またはパスワードが正しありません。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="custom-control-label w-100" for="remember">
                            次回から自動的にログインする
                        </label>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="mt-3 mb-3 btn diet-button diet-button-login w-75">
                        ログイン
                    </button>
                    <a class="mt-3 mb-3 btn diet-button diet-button-register w-75" href="{{ route('register') }}">
                        新規登録はこちら
                    </a>
                </div>
            </form>

            <hr>

            <div class="form-group">
                <a class="btn btn-link mt-3 d-flex justify-content-center diet-login-text" href="{{ route('password.request') }}">パスワードをお忘れの場合</a>
            </div>
        </div>
    </div>
</div>
@endsection