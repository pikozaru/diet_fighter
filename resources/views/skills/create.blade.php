@extends('layouts.app')

@section('content')
<div class="ml-3 mr-3 mt-3">
    <div class="now_point d-flex align-items-center justify-content-center shadow-sm">
        <p style="margin:0;"><b>ポイント：{{$user->point}}</b></p>
    </div>
    
    <!--アップグレード-->
    @foreach($skills as $skill)
        @if(in_array($skill->id, $possessionSkillIds))
            <div class="card card-body mb-1 shadow-sm">
                
                <!--ヒール-->
                @if($skill->id == 1)
                    <div class="text-right">
                        <p class="skill-level-under">Lv：{{$heal->level}}</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h3 class="mb-5 pb-4" style="border-bottom:solid 2px #ffcb42;">{{$skill->name}}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                            </div>
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                            </div>
                        </div>
                        <p class="text-center skill-border pt-3 pb-3 mb-4">{{$skill->description}}</p>
                        <div class="text-center">    
                            <h4 class="list-arrow mb-4">次のレベル</h4>
                            <div class="text-center">
                                <p class="list-arrow-sub">回復量UP</p>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-4 text-right">
                                        <p class="font-size-magnification">{{$heal->magnification + 30}}</p>
                                    </div>
                                    <div class="col-4 float-center">
                                        <i class="fas fa-chevron-right font-size-arrow"></i>
                                    </div>
                                    <div class="col-4 text-left">
                                        <p class="font-size-magnification">{{$heal->magnification + 32}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($user->point < $heal->required_upgrade_points)
                            <div class="text-right mt-5">
                                <button class="diet-button diet-button-danger">
                                    ポイント不足：{{$heal->required_upgrade_points}}
                                </button>
                            </div>
                        @else
                            <div class="text-right mt-5">
                                <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#upgrade{{$skill->id}}">
                                    アップグレード：{{$heal->required_upgrade_points}}
                                </button>
                            </div>
                        @endif
                    </div>
                
                <!--ファイア-->    
                @elseif($skill->id == 2)
                    <div class="text-right">
                        <p class="skill-level-under">Lv：{{$fire->level}}</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h3 class="mb-5 pb-4" style="border-bottom:solid 2px #ffcb42;">{{$skill->name}}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                            </div>
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                            </div>
                        </div>
                        <p class="text-center skill-border pt-3 pb-3 mb-4">{{$skill->description}}</p>
                        <div class="text-center">    
                            <h4 class="list-arrow mb-4">次のレベル</h4>
                            <div class="text-center">
                                <p class="list-arrow-sub">攻撃倍率UP</p>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-4 text-right">
                                        <p class="font-size-magnification">{{$fire->magnification}}</p>
                                    </div>
                                    <div class="col-4 float-center">
                                        <i class="fas fa-chevron-right font-size-arrow"></i>
                                    </div>
                                    <div class="col-4 text-left">
                                        <p class="font-size-magnification">{{$fire->magnification + 0.1}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($user->point < $fire->required_upgrade_points)
                            <div class="text-right mt-5">
                                <button class="diet-button diet-button-danger">
                                    ポイント不足：{{$fire->required_upgrade_points}}
                                </button>
                            </div>
                        @else
                            <div class="text-right mt-5">
                                <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#upgrade{{$skill->id}}">
                                    アップグレード：{{$fire->required_upgrade_points}}
                                </button>
                            </div>
                        @endif
                    </div>
                
                <!--アイス-->
                @elseif($skill->id == 3)
                    <div class="text-right">
                        <p class="skill-level-under">Lv：{{$ice->level}}</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h3 class="mb-5 under">{{$skill->name}}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                            </div>
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                            </div>
                        </div>
                        <p class="text-center skill-border pt-3 pb-3 mb-4">{{$skill->description}}</p>
                        <div class="text-center">
                            <h4 class="list-arrow mb-4">次のレベル</h4>
                            <div class="text-center">
                                <p class="list-arrow-sub">攻撃倍率UP</p>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-4 text-right">
                                        <p class="font-size-magnification">{{$ice->magnification}}</p>
                                    </div>
                                    <div class="col-4 float-center">
                                        <i class="fas fa-chevron-right font-size-arrow"></i>
                                    </div>
                                    <div class="col-4 text-left">
                                        <p class="font-size-magnification">{{$ice->magnification + 0.1}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->point < $ice->required_upgrade_points)
                            <div class="text-right mt-5">
                                <button class="diet-button diet-button-danger">
                                    ポイント不足：{{$ice->required_upgrade_points}}
                                </button>
                            </div>
                        @else
                            <div class="text-right mt-5">
                                <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#upgrade{{$skill->id}}">
                                    アップグレード：{{$ice->required_upgrade_points}}
                                </button>
                            </div>
                        @endif
                    </div>
                
                <!--鍛える-->
                @elseif($skill->id == 4)
                    <!--スキル詳細-->
                    <div class="text-right">
                        <p class="skill-level-under">Lv：{{$poison->level}}</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h3 class="mb-5 under">{{$skill->name}}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                            </div>
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                            </div>
                        </div>
                        <p class="text-center skill-border pt-3 pb-3 mb-4">{{$skill->description}}</p>
                        <div class="text-center">
                            <h4 class="list-arrow mb-4">次のレベル</h4>
                            <div class="text-center">
                                <p class="list-arrow-sub">攻撃倍率UP</p>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-4 text-right">
                                        <p class="font-size-magnification">{{$poison->magnification}}</p>
                                    </div>
                                    <div class="col-4 float-center">
                                        <i class="fas fa-chevron-right font-size-arrow"></i>
                                    </div>
                                    <div class="col-4 text-left">
                                        <p class="font-size-magnification">{{$poison->magnification + 0.1}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->point < $poison->required_upgrade_points)
                            <div class="text-right mt-5">
                                <button class="diet-button diet-button-danger">
                                    ポイント不足：{{$poison->required_upgrade_points}}
                                </button>
                            </div>
                        @else
                            <div class="text-right mt-5">
                                <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#upgrade{{$skill->id}}">
                                    アップグレード：{{$poison->required_upgrade_points}}
                                </button>
                            </div>
                        @endif
                    </div>
                    
                <!--貫通攻撃-->
                @elseif($skill->id == 5)
                    <div class="text-right">
                        <p class="skill-level-under">Lv：{{$train->level}}</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h3 class="mb-5 under">{{$skill->name}}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                            </div>
                            <div class="col-sm text-center">
                                <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                            </div>
                        </div>
                        <p class="text-center skill-border pt-3 pb-3 mb-4">{{$skill->description}}</p>
                        <div class="text-center">
                            <h4 class="list-arrow mb-4">次のレベル</h4>
                            <div class="text-center">
                                <p class="list-arrow-sub">攻撃倍率UP</p>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-4 text-right">
                                        <p class="font-size-magnification">{{$train->magnification}}</p>
                                    </div>
                                    <div class="col-4 float-center">
                                        <i class="fas fa-chevron-right font-size-arrow"></i>
                                    </div>
                                    <div class="col-4 text-left">
                                        <p class="font-size-magnification">{{$train->magnification + 0.1}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->point < $train->required_upgrade_points)
                            <div class="text-right mt-5">
                                <button class="diet-button diet-button-danger">
                                    ポイント不足：{{$train->required_upgrade_points}}
                                </button>
                            </div>
                        @else
                            <div class="text-right mt-5">
                                <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#upgrade{{$skill->id}}">
                                    アップグレード：{{$train->required_upgrade_points}}
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <!--モーダル（アップグレード）-->
            <div class="modal fade" id="upgrade{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                            <h4>アップグレードしますか？</h4>
                        </div>
                        <!--選択したスキルをアップグレード-->
                        <div class="modal-body text-center">
                            
                            <!--ヒール-->
                            @if($skill->id == 1)
                                <div class="text-center">
                                    <p class="list-arrow-sub">Lv</p>
                                </div>
                                <div class="container mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$heal->level}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$heal->level + 1}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="list-arrow-sub">回復量</p>
                                </div>
                                <div class="container mb-4 pb-3">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$heal->magnification + 30}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$heal->magnification + 32}}</p>
                                        </div>
                                    </div>
                                </div>
                            
                            <!--ファイヤ-->
                            @elseif($skill->id == 2)
                                <div class="text-center">
                                    <p class="list-arrow-sub">Lv</p>
                                </div>
                                <div class="container mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$fire->level}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$fire->level + 1}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="list-arrow-sub">攻撃倍率</p>
                                </div>
                                <div class="container mb-4 pb-3">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$fire->magnification}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$fire->magnification + 0.1}}</p>
                                        </div>
                                    </div>
                                </div>
                            
                            <!--アイス-->
                            @elseif($skill->id == 3)
                                <div class="text-center">
                                    <p class="list-arrow-sub">Lv</p>
                                </div>
                                <div class="container mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$ice->level}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$ice->level + 1}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="list-arrow-sub">攻撃倍率</p>
                                </div>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$ice->magnification}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$ice->magnification + 0.1}}</p>
                                        </div>
                                    </div>
                                </div>
                            
                            <!--鍛える-->
                            @elseif($skill->id == 4)
                                <div class="text-center">
                                    <p class="list-arrow-sub">Lv</p>
                                </div>
                                <div class="container mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$poison->level}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$poison->level + 1}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="list-arrow-sub">攻撃倍率</p>
                                </div>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$poison->magnification}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$poison->magnification + 0.1}}</p>
                                        </div>
                                    </div>
                                </div>
                            
                            <!--貫通攻撃-->
                            @elseif($skill->id == 5)
                                <div class="text-center">
                                    <p class="list-arrow-sub">Lv</p>
                                </div>
                                <div class="container mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$train->level}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$train->level + 1}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="list-arrow-sub">攻撃倍率</p>
                                </div>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-4 text-right">
                                            <p class="font-size-magnification">{{$train->magnification}}</p>
                                        </div>
                                        <div class="col-4 float-center">
                                            <i class="fas fa-chevron-right font-size-arrow"></i>
                                        </div>
                                        <div class="col-4 text-left">
                                            <p class="font-size-magnification">{{$train->magnification + 0.1}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                            <button type="button" class="diet-button diet-button-back" data-dismiss="modal">やめる</button>
                            <form method="POST" action="/skills/levelUp">
                                <form method="POST" action="/skills/levelUp">
                                    {{ csrf_field() }}
                                    <button type="submit" class="diet-button diet-button-enter" name="skill_id" value="{{$skill->id}}">アップグレード</button>
                                </form>
                            </from>
                        </div>
                    </div>
                 </div>
            </div>
         
        <!--スキル習得-->    
        @else
            <div class="card card-body mb-1 shadow-sm">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center">
                            <h4 class="mb-5 under">{{$skill->name}}</h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm text-center">
                            <p class="list-arrow-sub">消費行動力：{{$skill->required_action_points}}</p>
                        </div>
                        <div class="col-sm text-center">
                            <p class="list-arrow-sub">消費MP：{{$skill->consumed_magic_points}}</p>
                        </div>
                    </div>
                    <p class="text-center skill-border pt-3 pb-3">{{$skill->description}}</p>
                    
                    @if($user->point < $skill->required_points)
                        <div class="text-right mt-5">
                            <button class="diet-button diet-button-danger">
                                ポイント不足：{{$skill->required_points}}
                            </button>
                        </div>
                    @else
                        <div class="text-right mt-5">
                            <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#modal{{$skill->id}}">
                                習得：{{$skill->required_points}}
                            </button>
                        </div>    
                        
                        <!--モーダル（習得）-->
                        <!--スキルを選択して、習得-->
                        <div class="modal fade" id="modal{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                        <h4>習得しますか？</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h3>{{$skill->name}}</h3>
                                        <p class="list-arrow-sub">{{$skill->description}}</p>
                                        <div class="mb-4 pb-3"></div>
                                    </div>
                                
                                    <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                        <button type="button" class="diet-button diet-button-back" data-dismiss="modal">やめる</button>
                                        <form method="POST" action="/skills">
                                            <form method="POST" action="/skills">
                                                {{ csrf_field() }}
                                                <button type="submit" class="diet-button diet-button-enter" name="skill_id" value="{{$skill->id}}">習得する</button>
                                            </form>
                                        </from>
                                    </div>
                                </div>
                             </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection