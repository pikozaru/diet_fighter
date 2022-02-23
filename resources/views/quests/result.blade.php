@extends('layouts.quest_preparation_app')

@section('quest_preparation_content')

<!--クエスト期間中の場合-->
@if($carbon->format('Y-m-d h:i') < $quest->end_at->format('Y-m-d h:i'))
    <h5 class="text-center">※クエスト中です。</h5>
<!--クエスト終了の場合-->
@else
    <h4 class="text-center">期間が終了しました！<br>お疲れ様です！</h4>
    
    <form action="{{ route('quests.finish', $quest->id) }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$quest->id}}">
        <div class="text-center">    
            <button class="diet-button diet-button-enter w-50 mt-3 mb-2" type="submit" name="finish">終了</button>
        </div>
    
        <!--リザルト-->
        <div class="card card-body shadow-sm mt-2 mb-2">
            <h3 class="mx-auto text-center under mb-4">リザルト</h3>
            <!--ランクアップ処理-->
            @if($rankUpJudge >= 0)    
                <div class="container">
                    <div class="text-center">    
                        <h4 style="padding-bottom:5px; margin-bottom:7px; border-bottom: 1.7px solid #ffcb42;"><b>ランクアップ！</b></h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-5 text-right">
                            <p class="font-size-magnification">{{$user->last_time_rank}}</p>
                        </div>
                        <div class="col-2 text-center">
                            <i class="fas fa-chevron-right font-size-arrow"></i>
                        </div>
                        <div class="col-5 text-left">
                            <p class="font-size-magnification">{{$user->rank}}</p>
                        </div>
                        <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$user->rank - $user->last_time_rank}}</p>
                    </div>
                </div>
            @endif
            <div class="container">
                <div class="text-center">    
                    <h4 style="padding-bottom:5px; margin-bottom:7px; border-bottom: 1.7px solid #ffcb42;"><b>スコア</b></h4>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 text-center">
                        <p style="font-size:30px; margin:0;">{{$quest->score}}</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <h5 class="list-arrow-sub" style="margin-bottom:7px;">トータルスコア</h5>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 text-right">
                        <p class="font-size-magnification">{{$user->total_score - $user->clear_score}}</p>
                    </div>
                    <div class="col-2 text-center">
                        <i class="fas fa-chevron-right font-size-arrow"></i>
                    </div>
                    <div class="col-5 text-left">
                        <p class="font-size-magnification">{{$user->total_score}}</p>
                    </div>
                    <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$user->clear_score}}</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('rankings.index') }}">
                        <p class="diet-button diet-button-enter w-50" style="border-radius: 20px;">ランキングへ</p>
                    </a>
                </div>
                <div class="text-center mt-4">    
                    <h4 style="padding-bottom:5px; margin-bottom:7px; border-bottom: 1.7px solid #ffcb42;"><b>倒した敵の数</b></h4>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 text-center">
                        <p style="font-size:30px; margin:0;">{{$quest->enemy_destorying_count}}<span class="ml-1" style="font-size:16px;">体</span></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
@endsection