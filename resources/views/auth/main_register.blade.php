@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="mb-3">本会員登録</h3>

            <hr>

            <form method="POST" action="{{ route('register.pre_check') }}">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope fa-2x mr-2" style="color: #ffcb42;"></i><label for="name" class="col-form-label text-md-left">ユーザーネーム<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror input-text" name="name" value="{{ old('name') }}" required placeholder="ゆーしゃ">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>ユーザーネームが入力されていません</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock fa-2x mr-2" style="color: #ffcb42;"></i><label for="height" class="col-form-label text-md-left">身長<span class="diet-require-input-label-text">※必須</span></label>

                    <input id="height" type="number" class="form-control @error('height') is-invalid @enderror input-text" name="height" required>

                    @error('height')
                    <span class="invalid-feedback" role="alert">
                        <strong>身長が入力されていません
                        </strong>
                    </span>
                    @enderror
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