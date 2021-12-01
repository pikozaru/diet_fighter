@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mx-auto text-center under mt-4 mb-4">パスワード変更</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <i class="fas fa-lock fa-2x ml-1 mr-2" style="color: #ffcb42;"></i><label for="password" class="col-form-label text-md-left" style="font-size:17px;">新しいパスワード<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-text" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-exclamation fa-2x ml-2 mr-3" style="color: #ffcb42;"></i><label for="password-confirm" class="col-form-label text-md-left" style="font-size:17px;">パスワード確認<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="password-confirm" type="password" class="form-control input-text" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group mt-5 mb-4">
                    <div class="text-center">
                        <button type="submit" class="btn diet-button diet-button-pw-reset w-75">
                            パスワードを変更
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
