@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mx-auto text-center under mt-4 mb-4">新規会員登録</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-user fa-2x ml-1 mr-2" style="color: #ffcb42;"></i><label for="name" class="col-form-label text-md-left" style="font-size:17px;">ユーザーネーム<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror input-text" name="name" value="{{ old('name') }}" required maxlength="30">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <i class="fas fa-ruler ml-1 mr-2" style="color: #ffcb42; font-size:23px;"></i><label for="height" class="col-form-label text-md-left" style="font-size:17px;">身長<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="height" type="number" class="form-control @error('height') is-invalid @enderror input-text text-center" name="height" value="{{ old('height') }}" required min="100" max="250" step="0.1" style="width:120px; font-size:20px;">
                    
                    @error('height')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <i class="fas fa-envelope fa-2x ml-1 mr-2" style="color: #ffcb42;"></i><label for="email" class="col-form-label text-md-left position-relative" style="font-size:17px; bottom:4px;">メールアドレス<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror input-text" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="yusya@diet.com">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock fa-2x ml-1 mr-2" style="color: #ffcb42;"></i><label for="password" class="col-form-label text-md-left" style="font-size:17px;">パスワード<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-text" name="password" required autocomplete="new-password" minlength="8">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-exclamation fa-2x ml-2 mr-3" style="color: #ffcb42;"></i><label for="password-confirm" class="col-form-label text-md-left position-relative" style="font-size:17px; bottom:4px;">パスワード確認<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="password-confirm" type="password" class="form-control input-text" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn diet-button diet-button-register w-75">
                        アカウント作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection