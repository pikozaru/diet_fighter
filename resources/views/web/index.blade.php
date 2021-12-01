@extends('layouts.sign_in_app')

@section('sign_in_content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <link rel="stylesheet" href="{{ asset('css/diet_fiter.css') }}">
        <div class="row" style="height:10rem">
            <div class="col">
            </div>
            <div class="col top-heading">
                <h3 class="mt-4 text-center" style="font-size:clamp(18px,5vw,25px);"><b>楽しいダイエットを<br>あなたに</b></h3>
                <p style="white-space: nowrap;">記録された体重を使って、<br>毎日のダイエットを楽しもう！</p>
                <a class="mt-2 btn diet-button diet-button-login w-100" href="{{ route('login') }}">ログイン</a>
            </div>
        </div>
    </div>
</div>
<h3 class="text-center mb-5"><b>ダイエットファイター</b><span style="font-size:14px;">とは？</span></h3>
<div class="container">
    <div class="row">
        <div class="col-sm-6 text-center mb-4">
            <h5><b>1.記録を管理</b></h5>
            <div class="mt-4 mb-3 position-relative" style="left:15px;">    
                <i class="fas fa-clipboard fa-4x" style="color:#ffcb42;"></i>
                <i class="fas fa-pen fa-2x" style="color:#ffcb42;"></i>
            </div>
            <p style="font-size:13px;">体重、体脂肪率が簡単に記録可能。<br>BMIやグラフの閲覧も出来ます。</p>
        </div>
        <div class="col-sm-6 text-center mb-4">
            <h5><b>2.クエスト</b></h5>
            <i class="fas fa-khanda fa-4x mt-3 mb-3" style="color:#ffcb42;"></i>
            <p style="font-size:13px;">記録から行動力を獲得し、<br>クエスト期間内でハイスコアを目指そう！</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 text-center mb-4">
            <h5><b>3.スキルやアイテム</b></h5>
            <div class="mt-4 mb-3">
                <i class="fas fa-hat-wizard fa-4x mr-2" style="color:#ffcb42;"></i>
                <i class="fas fa-flask fa-4x ml-2" style="color:#ffcb42;"></i>
            </div>
            <p style="font-size:13px;">クエストで獲得したポイントで、<br>スキル習得やアイテム購入をしよう！</p>
        </div>
        <div class="col-sm-6 text-center">
            <h5><b>4.ランキング</b></h5>
            <div class="mb-3">    
                <i class="fas fa-crown" style="color:#ffcb42;"></i>
                <br>
                <i class="fas fa-users fa-4x" style="color:#ffcb42;"></i>
            </div>
            <p style="font-size:13px;">他のファイターとスコアで競い合おう！</p>
        </div>
    </div>
</div>
<div class="text-center">
    <img src="{{asset('img/slime.gif')}}">
    <img src="{{asset('img/red_slime.gif')}}">
    <br>
    <a class="btn diet-button diet-button-login w-75" href="{{ route('login') }}">はじめてみる</a>
</div>
@endsection