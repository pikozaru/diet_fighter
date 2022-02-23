@extends('layouts.quest_app')

@section('quest_content')
<form name="form1" method="POST" action="{{ route('quests.command', $quest->id) }}">
    {{ csrf_field() }}
    
    <!--リザルト-->
    @if($quest->start_judge == 2 or $quest->start_judge == 4)
        <div class="battle_background position-relative">
            <div class="text-log">
                <h4 class="text-center position-absolute" style="top:10px; right:0; left:0; color:#ffffff; font-family: DotGothic16;">敵を倒した！</h4>
            </div>
            <button class="position-absolute" style="bottom:6px; right:10px; color:#ffffff; background-color:#000000; border:none; border-bottom: 3px solid #ffffff;" type="submit" name="nextQuest" value="nextQuest">
                <h5 style="font-family: DotGothic16;">次に進む<i class="fas fa-chevron-right pl-2"></i></h5>
            </button>
        </div>
        
        <!--レベルアップの表記-->
        @if($quest->start_judge == 4)
            <div class="card card-body shadow-sm mt-2 mb-2">
                <div class="container">
                    <div class="text-center">    
                        <h4 style="padding-bottom:5px; margin-bottom:7px; border-bottom: 1.7px solid #ffcb42;"><b>レベルアップ！</b></h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-5 text-right">
                            <p class="font-size-magnification">{{$quest->last_time_level}}</p>
                        </div>
                        <div class="col-2 text-center">
                            <i class="fas fa-chevron-right font-size-arrow"></i>
                        </div>
                        <div class="col-5 text-left">
                            <p class="font-size-magnification">{{$quest->level}}</p>
                        </div>
                        <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$quest->level - $quest->last_time_level}}</p>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            <h5>攻撃力UP</h5>
                            <p class="font-size-magnification">{{$quest->attack_point}}</p>
                            <p style="color: #66cdaa;">+3</p>
                        </div>
                        <div class="col text-center">
                            <h5>防御力UP</h5>
                            <p class="font-size-magnification">{{$quest->defense_point}}</p>
                            <p style="color: #66cdaa;">+1</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card card-body shadow-sm">
            <div class="container">
                <div class="text-center">    
                    <h5 class="list-arrow-sub" style="margin-bottom:7px;">経験値</h5>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 text-right">
                        <p class="font-size-magnification">{{$quest->exp - $quest->clear_exp}}</p>
                    </div>
                    <div class="col-2 text-center">
                        <i class="fas fa-chevron-right font-size-arrow"></i>
                    </div>
                    <div class="col-5 text-left">
                        <p class="font-size-magnification">{{$quest->exp}}</p>
                    </div>
                    <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$quest->clear_score}}</p>
                </div>
                <div class="text-center">    
                    <h5 class="list-arrow-sub" style="margin-bottom:7px;">スコア</h5>
                </div>
                <div class="row justify-content-center">
                    <br>
                    <div class="col-5 text-right">
                        <p class="font-size-magnification">{{$quest->score - $quest->clear_score}}</p>
                    </div>
                    <div class="col-2 text-center">
                        <i class="fas fa-chevron-right font-size-arrow"></i>
                    </div>
                    <div class="col-5 text-left">
                        <p class="font-size-magnification">{{$quest->score}}</p>
                    </div>
                    <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$quest->clear_score}}</p>
                </div>
                <div class="text-center">    
                    <h5 class="list-arrow-sub" style="margin-bottom:7px;">ポイント</h5>
                </div>
                <div class="row justify-content-center">
                    <br>
                    <div class="col-5 text-right">
                        <p class="font-size-magnification">{{$user->point - $user->clear_point}}</p>
                    </div>
                    <div class="col-2 text-center">
                        <i class="fas fa-chevron-right font-size-arrow"></i>
                    </div>
                    <div class="col-5 text-left">
                        <p class="font-size-magnification">{{$user->point}}</p>
                    </div>
                    <p class="position-relative" style="bottom:15px; margin-bottom:0; color: #66cdaa;">+{{$user->clear_point}}</p>
                </div>
            </div>
        </div>
    <!--クエスト画面-->
    @else        
        <div class="battle_background position-relative">
            
            <!--クエスト初回の表記-->
            @if($quest->start_judge == 1)
                <div class="text-log">
                    <h4 class="text-center position-absolute" style="top:10px; right:0; left:0; font-family: DotGothic16;">敵が現れた！</h4>
                </div>
            <!--クエスト2回目以降の表記-->
            @else
                <div class="text-log">
                    @foreach($actionHistories as $actionHistory)
                        <p class="ml-2">{!! nl2br(e($actionHistory->log)) !!}</p>
                    @endforeach
                </div>
            @endif
            <div class="container position-absolute" style="bottom:0; right:0; left:0; width:100%;">
                <div class="row justify-content-center d-flex align-items-end">    
                    @foreach ($quest->enemyDataBases as $enemyDatabase)
                        <div class="col text-center">
                            
                            <!--敵のHPによって「状態名」の色を変更-->
                            @if($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point > 0.5)
                                <div style="color: #ffffff;">    
                                    @if($enemyDatabase->frozen_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:1px;">氷結：{{$enemyDatabase->frozen_count}}</p>
                                    @endif
                                    @if($enemyDatabase->poison_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:0;">毒：{{$enemyDatabase->poison_count}}</p>
                                    @endif
                                </div>
                            @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.5 and $enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point >= 0.3)
                                <div style="color: #ffcb42;">
                                    @if($enemyDatabase->frozen_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:1px;">氷結：{{$enemyDatabase->frozen_count}}</p>
                                    @endif
                                    @if($enemyDatabase->poison_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:0;">毒：{{$enemyDatabase->poison_count}}</p>
                                    @endif
                                </div>
                            @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.3)
                                <div class="position-relative" style="top:13px; color: #EF454A;">    
                                    @if($enemyDatabase->frozen_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:1px;">氷結：{{$enemyDatabase->frozen_count}}</p>
                                    @endif
                                    @if($enemyDatabase->poison_count > 0)
                                        <p class="text-right" style="display:inline; line-height:1; margin-bottom:0;">毒：{{$enemyDatabase->poison_count}}</p>
                                    @endif
                                </div>
                            @endif
                            
                            <!--敵画像をidによってそれぞれ適用-->
                            @if($enemyDatabase->enemy_id == 1)
                                <img src="{{asset('img/slime.gif')}}">
                            @elseif($enemyDatabase->enemy_id == 2)
                                <img src="{{asset('img/red_slime.gif')}}">
                            @elseif($enemyDatabase->enemy_id == 3)
                                <img src="{{asset('img/zombie.gif')}}" style="width:70px;">
                            @elseif($enemyDatabase->enemy_id == 4)
                                <img src="{{asset('img/moving_flower.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 5)
                                <img src="{{asset('img/skeleton.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 6)
                                <img src="{{asset('img/silver_slime.gif')}}">
                            @elseif($enemyDatabase->enemy_id == 7)
                                <img src="{{asset('img/gold_slime.gif')}}">
                            @elseif($enemyDatabase->enemy_id == 8)
                                @if($quest->start_judge == 1)
                                    <div class="text-center position-relative" style="top:20px;">    
                                        <h5 class="position-relative" style="margin:0; top:5px;">キケン！</h5>
                                        <i class="fas fa-caret-down"></i>
                                    </div>
                                @endif
                                <img src="{{asset('img/soul_eater.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 9)
                                <img src="{{asset('img/hell_bird.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 10)
                                <img src="{{asset('img/magician.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 11)
                                <img src="{{asset('img/moving_armor.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 12)
                                <img src="{{asset('img/fox.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 13)
                                <img src="{{asset('img/red_dragon.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 14)
                                <img src="{{asset('img/blue_dragon.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 15)
                                <img src="{{asset('img/gold_dragon.gif')}}" style="width:60px;">
                            @elseif($enemyDatabase->enemy_id == 16)
                                <img src="{{asset('img/dark_dragon.gif')}}" style="width:60px;">
                            @endif
                            
                            <!--敵のHPによって敵の「名前」の色を変更-->
                            @if($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point > 0.5)
                                <div style="color: #ffffff;">    
                                    <p style="font-size:clamp(12px,3vw,16px);">{{$enemyDatabase->enemy->name}}</p>
                                </div>
                            @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.5 and $enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point >= 0.3)
                                <div style="color: #ffcb42;">
                                    <p style="font-size:clamp(12px,3vw,16px);">{{$enemyDatabase->enemy->name}}</p>
                                </div>
                            @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.3)
                                <div style="color: #EF454A;">
                                    <p style="font-size:clamp(12px,3vw,16px);">{{$enemyDatabase->enemy->name}}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!--プレイヤー情報-->
        <div class="container easy_information">
            <div class="row justify-content-center">
                <div class="col-11 text-center" style="padding:0;">
                    <h5>{{$user->name}}</h5>
                    <div class="container">
                        <div class="row justify-content-center mb-2">
                            <div class="col-sm text-center">
                                <b>Lv : {{$quest->level}}</b>
                            </div>
                            <div class="col-sm text-center">
                                <b>行動力 : {{$quest->action_point}}</b>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <div class="container-position2">
                                    <b class="position-relative" style="right:30px; top:-9px;">HP</b>
                                    <div class="mx-auto" id="containerHP2"></div>
                                </div>
                            </div>
                            <div class="col-sm text-center">
                                <div class="container-position2">
                                    @if($quest->hi_potion_count > 0)
                                        <b class="position-relative" style="right:11px; top:-9px;">MP<span class="position-relative" style="left:60px;">∞：{{$quest->hi_potion_count}}</span></b>
                                    @else
                                        <b class="position-relative" style="right:30px; top:-9px;">MP</b>
                                        <div class="mx-auto" id="containerMP2"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mb-3">
                        <div class="row justify-content-center">
                            @if($quest->train_count > 0)
                                <div class="col text-center" style="white-space:nowrap;">
                                    <b style="font-size:12px;">攻撃力</b>
                                    <i class="fas fa-angle-double-up"></i>
                                    <b style="font-size:12px;">{{$quest->train_count}}</b>
                                </div>
                            @endif
                            @if($quest->score_up_count > 0)
                                <div class="col text-center" style="white-space:nowrap;">
                                    <b style="font-size:12px;">スコア</b>
                                    <i class="fas fa-angle-double-up"></i>
                                    <b style="font-size:12px;">{{$quest->score_up_count}}</b>
                                </div>
                            @endif
                            @if($quest->point_up_count > 0)
                                <div class="col text-center" style="white-space:nowrap;">
                                    <b style="font-size:12px;">ポイント</b>
                                    <i class="fas fa-angle-double-up"></i>
                                    <b style="font-size:12px;">{{$quest->point_up_count}}</b>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <a class="btn position-relative" style="bottom:20px; left:20px; box-shadow:none; height:20px;" href="#" data-toggle="modal" data-target="#status">
                            <p class="link_arrow link_arrow--right" style="font-size:14px;">ステータス</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!--クエスト終了ボタン（クエスト期間中は表示なし）-->
        @if($carbon->format('Y-m-d h:i') >= $quest->end_at->format('Y-m-d h:i'))
            <div class="text-center">
                <button type="button" class="diet-button diet-button-result w-75 mt-3" data-toggle="modal" data-target="#result">
                    <p style="font-size:17px; margin:0;">リザルトへ</p>
                    <p style="font-size:10px; margin:0;">クエスト期間が終了しました</p>
                </button>
            </div>    
            
            <!--モーダル（リザルト）-->    
            <div class="modal fade" id="result" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                            <h4>クエストを終了しますか？</h4>
                        </div>
                        <div class="modal-body text-left">
                            <p>※アクションポイント、アイテムは使用できなくなります。</p>
                            @if($quest->action_point > 0)
                                <p class="list-arrow-sub" style="font-size:12px; color:#EF454A; margin:0;">アクションポイントが<b>{{$quest->action_point}}</b>残っています</p>
                                <br>
                            @endif
                            @if($quest->magical_point > 0)
                                <p class="list-arrow-sub" style="font-size:12px; color:#EF454A;">MPが<b>{{$quest->magical_point}}</b>残っています</p>
                            @endif
                        </div>
                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                            <a class="diet-button diet-button-result text-center" style="border-radius: 20px;" href="{{ route('quests.rankCount', ['quest' => $quest->id]) }}">
                                リザルトへ
                            </a>
                        </div>
                    </div>
                 </div>
            </div>
        @endif
        
        <!--コマンド選択-->
        <div class="container mt-3">
            <div class="row justify-content-center">
                
                <!--攻撃-->
                <div class="col text-center">
                    <!--アクションポイント不足で選択不可能-->
                    @if($quest->action_point < 5)
                        <button class="diet-button diet-button-command-danger" disabled>
                            <p style="line-height:1.5;">攻撃</p>
                            <p class="position-relative" style="top:-10px; font-size:clamp(10px,3vw,12px); line-height:1; white-space:nowrap;">消費行動力：5</p>
                        </button>
                    <!--選択可能-->
                    @elseif($quest->action_point >= 5)
                        <button type="button" class="diet-button diet-button-command" data-toggle="modal" data-target="#attack">
                            <p style="line-height:1.5;">攻撃</p>
                        <p class="position-relative" style="top:-10px; font-size:clamp(10px,3vw,12px); line-height:1; white-space:nowrap;">消費行動力：5</p>
                        </button>
                            
                        <!--モーダル（敵選択）-->
                        <div class="modal fade" id="attack" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                        <h4>敵を選択</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        @foreach ($quest->enemyDataBases as $enemyDatabase)
                                            <div class="container mb-3">
                                                <div class="row justify-content-center d-flex align-items-end">
                                                    <div class="col-7 text-left">
                                                        
                                                        <!--敵のHPによって敵の（名前）の色を変更-->
                                                        @if($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point > 0.5)
                                                            <h5 class="list-arrow-enemy">{{$enemyDatabase->enemy->name}}</h5>
                                                        @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.5 and $enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point >= 0.3)
                                                            <h5 class="list-arrow-enemy" style="color: #ffcb42;">{{$enemyDatabase->enemy->name}}</h5>
                                                        @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point < 0.5)
                                                            <h5 class="list-arrow-enemy" style="color: #EF454A;">{{$enemyDatabase->enemy->name}}</h5>
                                                        @endif
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <button class="diet-button diet-button-command-enter" style="white-space: nowrap;" type="submit" name="attack" value="{{$enemyDatabase->id}}">
                                                            攻撃
                                                            <i class="fas fa-angle-right position-relative" style="left:10px;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                        <button type="button" class="diet-button diet-button-command-back" data-dismiss="modal">閉じる</button>
                                    </div>
                                </div>
                             </div>
                        </div>
                    @endif
                </div>
                
                <!--防御-->
                <div class="col text-center">
                    <!--アクションポイント不足で選択不可能-->
                    @if($quest->action_point < 2)
                        <button class="diet-button diet-button-command-danger" disabled>
                            <p style="line-height:1.5;">防御</p>
                            <p class="position-relative" style="top:-10px; font-size:clamp(10px,3vw,12px); line-height:1; white-space:nowrap;">消費行動力：2</p>
                        </button>
                    <!--選択可能-->
                    @elseif($quest->action_point >= 2)
                        <button class="diet-button diet-button-command" type="submit" name="defense" value="defense">
                            <p style="line-height:1.5;">防御</p>
                            <p class="position-relative" style="top:-10px; font-size:clamp(10px,3vw,12px); line-height:1; white-space:nowrap;">消費行動力：2</p>
                        </button>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center mt-3 mb-3">
                
                <!--アイテム-->
                <div class="col text-center">
                    <button type="button" class="diet-button diet-button-command" data-toggle="modal" data-target="#item">
                        アイテム
                    </button>
                </div>
                
                <!--スキル-->
                <div class="col text-center">
                    @if($possessionSkillsEmpty)
                        <button type="button" class="diet-button diet-button-command" data-toggle="modal" data-target="#skillNull">
                            スキル
                        </button>
                    @else
                        <button type="button" class="diet-button diet-button-command" data-toggle="modal" data-target="#skill">
                            スキル
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <!--モーダル（スキルなし）-->
        <div class="modal fade" id="skillNull" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                        <h4>スキル選択</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>習得済みのスキルがありません。</p>
                        <p>ポイントを使ってスキルを習得しましょう！</p>
                        <div class="text-center">
                            <a class="btn diet-button diet-button-command-enter" href="{{ route('skills.create') }}">スキルを習得する</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="diet-button diet-button-command-back" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
             </div>
        </div>
        
        <!--モーダル（スキルあり）-->
        <div class="modal fade" id="skill" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                        <h4>スキル選択</h4>
                    </div>
                    <div class="modal-body text-center">
                        <form name="form1" method="POST" action="{{ route('quests.command', $quest->id) }}">
                            {{ csrf_field() }}
                            @foreach($possessionSkills as $possessionSkill)
                                
                                <!--ヒール or 鍛える-->
                                @if($possessionSkill->skill->name === "ヒール" or $possessionSkill->skill->name === "鍛える")
                                    <div class="card card-body">
                                        <h5 class="mb-2">{{$possessionSkill->skill->name}}</h5>
                                        <p class="pt-2 pb-2" style="border-top: 1px solid #ffcb42; border-bottom: 1px solid #ffcb42;">{{$possessionSkill->skill->description}}</p>
                                        <div class="text-center">    
                                            <p class="list-arrow-sub">消費MP：{{$possessionSkill->skill->consumed_magic_points}}</p>
                                            <br>
                                            <p class="list-arrow-sub">消費行動力：{{$possessionSkill->skill->required_action_points}}</p>
                                        </div>
                                        
                                        <!--MPまたはアクションポイントが不足している場合-->
                                        @if($quest->magical_point < $possessionSkill->skill->consumed_magic_points or $quest->action_point < $possessionSkill->skill->required_action_points)
                                            <div class="text-right">    
                                                <button class="diet-button diet-button-danger float-right" disabled>
                                                    <!--MP不足で選択不可能-->
                                                    @if($quest->magical_point < $possessionSkill->skill->consumed_magic_points)
                                                        <p>MPが足りない！</p>
                                                    <!--アクションポイント不足で選択不可能-->
                                                    @elseif($quest->action_point < $possessionSkill->skill->required_action_points)
                                                        <p>ポイントが足りない！</p>
                                                    @endif
                                                </button>
                                            </div>
                                        <!--MPとアクションポイントがある場合-->
                                        @elseif($quest->magical_point >= $possessionSkill->skill->consumed_magic_points and $quest->action_point >= $possessionSkill->skill->required_action_points)
                                            <div class="text-right">    
                                                <button class="diet-button diet-button-command-enter text-right" name="selectSkill" type="submit" value="{{$possessionSkill->skill->name}}">
                                                    使う
                                                    <i class="fas fa-angle-right position-relative" style="left:10px;"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                
                                <!--それ以外のスキル-->
                                @else
                                    <div class="card card-body shadow-sm">
                                        <h5 class="mb-4">{{$possessionSkill->skill->name}}</h5>
                                        <p class="pt-2 pb-2" style="border-top: 1px solid #ffcb42; border-bottom: 1px solid #ffcb42;">{{$possessionSkill->skill->description}}</p>
                                        <div class="text-center">    
                                            <p class="list-arrow-sub">消費MP：{{$possessionSkill->skill->consumed_magic_points}}</p>
                                            <br>
                                            <p class="list-arrow-sub">消費行動力：{{$possessionSkill->skill->required_action_points}}</p>
                                        </div>
                                        <div class="cp_linetab">
                                            
                                            <!--MPまたはアクションポイントが不足している場合-->
                                            @if($quest->magical_point < $possessionSkill->skill->consumed_magic_points or $quest->action_point < $possessionSkill->skill->required_action_points)
                                                <button class="diet-button diet-button-danger" disabled>
                                                    <!--MP不足で選択不可能-->
                                                    @if($quest->magical_point < $possessionSkill->skill->consumed_magic_points)
                                                        <p>MPが足りない！</p>
                                                    <!--アクションポイント不足で選択不可能-->
                                                    @elseif($quest->action_point < $possessionSkill->skill->required_action_points)
                                                        <p>ポイントが足りない！</p>
                                                    @endif
                                                </button>
                                            <!--MPとアクションポイントがある場合-->
                                            @elseif($quest->magical_point >= $possessionSkill->skill->consumed_magic_points and $quest->action_point >= $possessionSkill->skill->required_action_points)
                                                <!--ドロップアウトボタン-->
                                                <input class="cp_linetab-input" id="{{$possessionSkill->skill->name}}" name="selectSkill" type="radio" value="{{$possessionSkill->skill->name}}" onclick="radioDeselection(this, {{$possessionSkill->skill_id}})">
                                                <label class="cp_linetab-label" for="{{$possessionSkill->skill->name}}">使う</label>
                                            @endif
                                            
                                            <!--ドロップアウト内容-->
                                            <div class="cp_linetab-content">
                                                <p>敵を選択</p>
                                                @foreach ($quest->enemyDataBases as $enemyDatabase)
                                                    <div class="container mb-3">
                                                        <div class="row justify-content-center d-flex align-items-end">
                                                            <div class="col-7 text-left">
                                                                
                                                                <!--敵のHPによって敵の（名前）の色を変更-->
                                                                @if($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point > 0.5)
                                                                    <h5 class="list-arrow-enemy">{{$enemyDatabase->enemy->name}}</h5>
                                                                @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point <= 0.5 and $enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point >= 0.3)
                                                                    <h5 class="list-arrow-enemy" style="color: #ffcb42;">{{$enemyDatabase->enemy->name}}</h5>
                                                                @elseif($enemyDatabase->now_hit_point / $enemyDatabase->now_max_hit_point < 0.5)
                                                                    <h5 class="list-arrow-enemy" style="color: #EF454A;">{{$enemyDatabase->enemy->name}}</h5>
                                                                @endif
                                                            </div>
                                                            <div class="col-5 text-right">
                                                                <button class="diet-button diet-button-command-enter" style="white-space: nowrap;" type="submit" name="enemyDataBases" value="{{$enemyDatabase->id}}">
                                                                    攻撃
                                                                    <i class="fas fa-angle-right position-relative" style="left:10px;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>   
                                    </div>
                                @endif
                            @endforeach
                        </form>
                    </div>
                        
                    <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                        <button type="button" class="diet-button diet-button-command-back" data-dismiss="modal">閉じる</button>
                    </div>
                </div>        
            </div>            
        </div>
        
        <!--モーダル（アイテム）-->
        <div class="modal fade" id="item" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                        <h4>アイテム選択</h4>
                    </div>
                    <div class="modal-body text-center">
                        <form name="formItem" method="POST" action="{{ route('quests.command', $quest->id) }}">
                            {{ csrf_field() }}
                            
                            <!--アイテム持ち込みなし-->
                            @if($questItems->isEmpty())
                                <h5 style="color:#999999;">アイテムがありません</h5>
                            @endif
                            
                            <!--アイテム持ち込みあり-->
                            @foreach($questItems as $questItem)
                                
                                <!--アイテム個数が0の場合-->
                                @if($questItem->possession_number == 0)    
                                    <div class="card card-body shadow-sm" style="color:#999999;">
                                        <h5 class="mb-4">{{$questItem->item->name}}</h5>
                                        <p class="pt-2 pb-2" style="border-top: 1px solid #ffe9b0; border-bottom: 1px solid #ffe9b0;">{{$questItem->item->description}}</p>
                                        <div class="text-right">
                                            <button class="diet-button diet-button-danger" style="white-space: nowrap;" type="submit" name="itemUse" value="{{$questItem->item->name}}" disabled>
                                                使う
                                                <i class="fas fa-angle-right position-relative" style="left:10px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                
                                <!--アイテム個数が1の場合-->
                                @else
                                    <div class="card card-body shadow-sm">
                                        <h5 class="mb-4">{{$questItem->item->name}}</h5>
                                        <p class="pt-2 pb-2" style="border-top: 1px solid #ffcb42; border-bottom: 1px solid #ffcb42;">{{$questItem->item->description}}</p>
                                        <div class="text-right">
                                            <button class="diet-button diet-button-command-enter" style="white-space: nowrap;" type="submit" name="itemUse" value="{{$questItem->item->name}}">
                                                使う
                                                <i class="fas fa-angle-right position-relative" style="left:10px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                        <button type="button" class="diet-button diet-button-command-back" data-dismiss="modal">閉じる</button>
                    </div>
                </div>        
            </div>            
        </div>
    @endif
</form>

<!--モーダル（ステータス）-->
<div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                <h4>ステータス</h4>
            </div>
            
            <!--ステータス内容-->
            <div class="modal-body text-center">
                <!--目標-->
                <h4 class="under">目標</h4>
                <div class="container mb-3" style="border-bottom: 1px solid #ffcb42;">
                    <div class="row justify-content-center d-flex align-items-end">
                        <div class="col text-center">
                            <p style="font-size:35px;"><b>{{$quest->weight_after}}</b><span style="font-size:16px;">kg</span></p>
                        </div>
                        <div class="col text-center">
                            @if ($quest->body_fat_percentage_after == null)
                                <p style="font-size:35px;"><b>--</b><span style="font-size:16px;">%</span></p>
                            @else
                                <p style="font-size:35px;"><b>{{$quest->body_fat_percentage_after}}</b><span style="font-size:16px;">%</span></p>
                            @endif
                        </div>
                    </div>
                </div>
                <h4 class="under">{{$user->name}}</h4>
                <h5>Lv.<span style="font-size:25px;">{{$quest->level}}</span></h5>
                <div class="mx-auto" id="containerExp"></div>
                <p>次のレベルまで：{{$subExp}}</p>
                <div class="container mb-3" style="border-bottom: 1px solid #ffcb42;">
                    <div class="row justify-content-center d-flex align-items-end">
                        <div class="col-4 text-right">
                            <p style="margin-bottom:0;">スコア</p>
                        </div>
                        <div class="col-4 text-center">
                            <p style="font-size:25px; margin-bottom:0;"><b>{{$quest->score}}</b></p>
                        </div>
                        <div class="col-4 text-left">
                        </div>
                    </div>
                </div>
                <p class="list-arrow-sub">行動力：{{$quest->action_point}}</p>
                <div class="container">
                    <div class="row justify-content-center d-flex align-items-start">
                        <div class="col-6 text-center">
                            <p class="list-arrow-sub">HP：{{$quest->hit_point}}/{{$quest->max_hit_point}}</p>
                            <br>
                            <p class="list-arrow-sub">MP：{{$quest->magical_point}}/{{$quest->max_magical_point}}</p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="list-arrow-sub">攻撃力：{{$quest->attack_point}}</p>
                            <br>
                            <p class="list-arrow-sub">防御力：{{$quest->defense_point}}</p>
                        </div>
                    </div>
                </div>
                <div class="mb-4" style="border-bottom: 1px solid #ffcb42;"></div>
                
                <div class="text-center">
                    <p>期間：{{$quest->value}}日</p>
                    <p>開始日：{{$quest->start_at->format('Y/n/d H時i分')}}</p>
                    <p>終了日：{{$quest->end_at->format('Y/n/d H時i分')}}</p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                <button type="button" class="diet-button diet-button-command-back" data-dismiss="modal">閉じる</button>
            </div>
        </div>
     </div>
</div>

<!--HPバー-->
<script>
    var nowHP = @json($nowHP);
    
    var bar = new ProgressBar.Line(containerHP2, {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 1400,
      color: '#FFEA82',
      trailColor: '#999',
      trailWidth: 4,
      svgStyle: null,
      from: {color: '#ffcb42'},
      to: {color: '#66cdaa'},
      step: (state, bar) => {
        bar.path.setAttribute('stroke', state.color);
      }
    });
    
    bar.animate(nowHP);
</script>

<!--MPバー-->
<script>
    var nowMP = @json($nowMP);
    var bar = new ProgressBar.Line(containerMP2, {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 1400,
      color: '#FFEA82',
      trailColor: '#999999',
      trailWidth: 4,
      svgStyle: null,
      from: {color: '#219ddd'},
      to: {color: '#219ddd'},
      step: (state, bar) => {
        bar.path.setAttribute('stroke', state.color);
      }
    });
    
    bar.animate(nowMP);
</script>

<!--expバー-->
<script>
    var nowExp = @json($nowExp);
    var bar = new ProgressBar.Line(containerExp, {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 1400,
      color: '#FFEA82',
      trailColor: '#999999',
      trailWidth: 4,
      svgStyle: null,
      from: {color: '#219ddd'},
      to: {color: '#219ddd'},
      step: (state, bar) => {
        bar.path.setAttribute('stroke', state.color);
      }
    });
    
    bar.animate(nowExp);
</script>

<script>
    var remove = 0;

    function radioDeselection(already, numeric) {
      if(remove == numeric) {
        already.checked = false;
        remove = 0;
      } else {
        remove = numeric;
      }
    }
</script>
@endsection