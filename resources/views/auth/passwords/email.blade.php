@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mx-auto text-center under mt-4 mb-4">パスワード再設定</h2>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope fa-2x ml-1 mr-2" style="color: #ffcb42;"></i><label for="email" class="col-form-label text-md-left position-relative" style="font-size:17px; bottom:4px;">メールアドレス</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror input-text" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-5 mb-4">
                    <div class="text-center">
                        <button type="submit" class="btn diet-button diet-button-pw-reset w-75">
                            送信
                        </button>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="text-center">
                        <a class="btn diet-button diet-button-pw-reset-back w-75" href="{{ route('login') }}">戻る</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
