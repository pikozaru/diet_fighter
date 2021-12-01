@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="mb-3">本会員登録</h3>

            <hr>

            <form method="POST" action="{{ route('register.main_registered') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="col-md-4 col-form-label text-md-right">ユーザーネーム</label>
                    <span class="">{{$user->name}}</span>
                    <input type="hidden" name="email" value="{{$user->name}}">
                </div>
                
                <div class="form-group">
                    <label for="height" class="col-md-4 col-form-label text-md-right">ユーザーネーム</label>
                    <span class="">{{$user->height}}</span>
                    <input type="hidden" name="number" value="{{$user->height}}">
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