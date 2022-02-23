@extends('layouts.quest_preparation_app')

@section('quest_preparation_content')
<h2 class="mx-auto text-center under mb-4" style="width:9em">クエスト準備</h2>

<div class="text-center">
    
    <!--体重未入力-->
    @if($record === null)
        <h4 style="color:red;">※体重が入力されていません！</h4>
        <p>ホームに戻って入力しよう！</p>
        <div class="button05">    
            <a class="btn diet-button diet-button-back" href="{{ route('mains.index') }}">ホームへ</a>
        </div>
        
    <!--体重入力済み-->
    @elseif($record !== null)
        <form method="POST" action="/quests">
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body shadow-sm">
                    <div class="container">
                        <!--現在の記録-->
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-6">
                                <p class="heading-color" style="font-size:clamp(1px,4.3vw,16px);">現在の体重</p>
                                <b class="weight-number">{{$record->weight}}<span style="font-size:clamp(18px,3vw,30px);">kg</span></b>
                            </div>
                            <div class="col-6">
                                <p class="heading-color" style="font-size:clamp(1px,4.3vw,16px);">現在の体脂肪率</p>
                                <b class="weight-number">{{$record->body_fat_percentage}}<span style="font-size:clamp(18px,3vw,30px);">%</span></b>
                            </div>
                        </div>
                    
                        <!--目標-->
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-sm">
                                <div class="text-center">
                                    <p class="list-arrow-sub position-relative" style="right:12px;">目標体重</p>
                                </div>
                                <input class="input-number mb-5" type="number" name="weight_after" min="35" max="200" step="0.01" style="width:110px;" required> kg
                            </div>
                            <div class="col-sm">
                                <div class="text-center">
                                    <p class="list-arrow-sub">目標体脂肪率(任意)</p>
                                </div>
                                <input class="input-number mb-5" type="number" name="body_fat_percentage_after" max="50" step="0.01" style="width:110px;"> %
                            </div>
                        </div>
                    </div>
                    
                    <!--期間-->
                    <div class="text-center">
                        <p class="list-arrow-sub">期間</p>
                    </div>
                    <div class="cp_ipradio">
                        <input type="radio" class="btn-check" name="end_at" id="option1" value="7" autocomplete="off" checked>
                        <label for="option1">7日間</label>
            
                        <input type="radio" class="btn-check" name="end_at" id="option2" value="14" autocomplete="off">
                        <label for="option2">14日間</label>
                        
                        <input type="radio" class="btn-check" name="end_at" id="option3" value="1m" autocomplete="off">
                        <label for="option3">30日間</label>
                    </div>
                    
                    <a class="btn diet-button diet-button-enter" style="width:180px;" data-toggle="modal" data-target="#exampleModalLong">アイテムを選択</a>
                </div>
            </div>    
            
            <!--モーダル（アイテム選択）-->
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                            <h4>アイテム選択</h4>
                        </div>
                        
                        <div class="modal-body" style="padding-bottom:0;">
                            <div class="container">
                                <div class="row d-flex align-items-end" style="border-bottom: 2px solid #ffcb42;">
                                    <div class="col-6 text-left">
                                        <p class="position-relative" style="top:15px;">アイテム</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p class="position-relative" style="top:15px;">所持数</p>
                                    </div>
                                    <div class="col-2">
                                    </div>
                                </div>
                                @foreach($possessionItems as $possessionItem)
                                    <!--アイテム所持数が0の場合-->
                                    @if($possessionItem->possession_number <= 0)
                                        <div class="row d-flex align-items-center" style="border-bottom: 1px solid #ffcb42;">
                                            <div class="col-6 text-left position-relative" style="top:5px; white-space:nowrap;">
                                                <label for="{{$possessionItem->item->name}}">{{$possessionItem->item->name}}</label>
                                            </div>
                                            <div class="col-4 position-relative" style="top:8px;">
                                                <p>{{$possessionItem->possession_number}}</p>
                                            </div>
                                            <div class="col-2 text-centr">
                                                <input type="radio" class="position-relative" style="top:2px; transform:scale(1.8);" name="item[]" id="{{$possessionItem->item->name}}" value="{{$possessionItem->item->id}}" disabled>
                                            </div>
                                        </div>
                                    
                                    <!--それ以外のアイテム-->
                                    @else
                                        <div class="row d-flex align-items-center" style="border-bottom: 1px solid #ffcb42;">
                                            <div class="col-6 text-left position-relative" style="top:5px; white-space:nowrap;">
                                                <label for="{{$possessionItem->item->name}}">{{$possessionItem->item->name}}</label>
                                            </div>
                                            <div class="col-4 position-relative" style="top:8px;">
                                                <p>{{$possessionItem->possession_number}}</p>
                                            </div>
                                            <div class="col-2">
                                                <input type="checkbox" class="btn-check light position-relative" style="top:2px; transform:scale(1.8);" name="item[]" id="{{$possessionItem->item->name}}" value="{{$possessionItem->item->id}}">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            <p class="text-danger mt-3 mb-2" style="margin-bottom:0; font-size:12px;">※2つまで選択可能</p>
                            
                            <!--アイテム選択の個数を確認-->
                            <script type="module">
                                $("input[type=checkbox]").click(function(){
                                    var $count = $("input[type=checkbox]:checked").length;
                                    var $not = $('input[type=checkbox]').not(':checked')
                                
                                    if($count >= 2) {
                                        $not.attr("disabled",true);
                                    }else{
                                        $not.attr("disabled",false);
                                    }
                                });
                            </script>
                        </div>
                    
                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                            <button type="button" class="mt-3 diet-button diet-button-back" data-dismiss="modal" aria-label="Close">戻る</button>
                            <button type="submit" class="mt-3 diet-button diet-button-enter" style="width:150px;">クエスト開始！</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection