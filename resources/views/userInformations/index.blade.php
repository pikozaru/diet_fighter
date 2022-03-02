@extends('layouts.app')

@section('content')
<h2 class="mx-auto text-center under mt-4 mb-5" style="width:10em">ユーザー情報</h2>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-left">
                    <p class="list-arrow-sub" style="margin:0;">ユーザーネーム</p>
                </div>
            </div>
            <div class="row justify-content-center" style="border-bottom: 1px solid #ffcb42;">
                <div class="col-8 text-left">
                    <p style="font-size:clamp(15px, 5vw, 18px);">{{$user->name}}</p>
                </div>
                <!--名前変更画面へ-->
                <div class="col-4 text-right">    
                    <a href="{{ route('edits.name') }}">
                        <i class="fas fa-edit"></i>
                        変更
                    </a>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col text-left">
                    <p class="list-arrow-sub" style="margin:0;">メールアドレス</p>
                </div>
            </div>
            <div class="row justify-content-center" style="border-bottom: 1px solid #ffcb42;">
                <div class="col-8 text-left">
                    <p style="font-size:clamp(15px, 5vw, 18px);">{{$user->email}}</p>
                </div>
                <!--メールアドレス変更画面へ-->
                <div class="col-4 text-right">    
                    <a href="{{ route('edits.email') }}">
                        <i class="fas fa-edit"></i>
                        変更
                    </a>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col text-left">
                    <p class="list-arrow-sub" style="margin:0;">身長</p>
                </div>
            </div>
            <div class="row justify-content-center" style="border-bottom: 1px solid #ffcb42;">
                <div class="col-8 text-left">
                    <p style="font-size:clamp(15px, 5vw, 18px);">{{$user->height}}</p>
                </div>
                <!--身長変更画面へ-->
                <div class="col-4 text-right">    
                    <a href="{{ route('edits.height') }}">
                        <i class="fas fa-edit"></i>
                        変更
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection