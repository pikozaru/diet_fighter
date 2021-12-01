@extends('layouts.app')

@section('content')
<h2 class="mx-auto text-center under mb-5" style="width:10em">アイテム購入</h2>

<div class="ml-3 mr-3 mt-3">
    <div class="now_point d-flex align-items-center justify-content-center shadow-sm">
        <p style="margin:0;"><b>所持ポイント：{{$user->point}}</b></p>
    </div>
    
    @foreach($possessionItems as $possessionItem)
        <div class="card card-body mb-1 shadow-sm">
            <div class="text-center">
                <h3 class="mb-4">{{$possessionItem->item->name}}</h3>
            </div>
            <div class="container pt-4" style="border-top:solid 2px #ffcb42;">
                <div class="text-center">
                    <p class="list-arrow-sub">{{$possessionItem->item->description}}</p>
                </div>
            </div>
            @if($user->point < $possessionItem->item->required_points)
                <div class="text-right mt-2">
                    <button class="diet-button diet-button-danger">
                        ポイント不足：{{$possessionItem->item->required_points}}
                    </button>
                </div>
            @else
                <div class="text-right mt-2">
                    <button type="button" class="diet-button diet-button-enter" data-toggle="modal" data-target="#modal{{$possessionItem->item->id}}">
                        ポイント：{{$possessionItem->item->required_points}}
                    </button>
                </div>    
                    
                <!-- モーダル -->
                <div class="modal fade" id="modal{{$possessionItem->item->id}}" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="POST" action="/items">
                                {{ csrf_field() }}
                                <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                    <h4>購入しますか？</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="text-center">
                                            <h5 class="list-arrow-sub">所持数：{{$possessionItem->possession_number}}/ {{$possessionItem->item->max_possession_number}}</h5>
                                        </div>
                                        <div class="field justify-content-center">
                                            <button type="button" class="count-button" id="down{{$possessionItem->item->id}}"><i class="fas fa-minus position-relative" style="bottom:0.6px;"></i></button>
                                            <input type="text" name="count" value="1" class="count-text" id="textbox{{$possessionItem->item->id}}" readonly>
                                            <button type="button" class="count-button" id="up{{$possessionItem->item->id}}"><i class="fas fa-plus position-relative" style="bottom:1px;"></i></button>
                                        </div>
                                        <div class="text-center">
                                            <label>消費ポイント：<input type="text" name="usePoint" value="300" class="count-point pt-1" id="usePoint{{$possessionItem->item->id}}"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                    <button type="button" class="diet-button diet-button-back" data-dismiss="modal">やめる</button>
                                    <button type="submit" class="diet-button diet-button-enter" name="clearing" value="{{$possessionItem->item->id}}">購入</button>
                                </div>
                            </form>
                        </div>
                     </div>
                </div>
            @endif
    
        </div>
    @endforeach
</div>

<script>
    (() => {
    //HTMLのid値を使って以下のDOM要素を取得
        const downbutton = document.getElementById('down1');
        const upbutton = document.getElementById('up1');
        const text = document.getElementById('textbox1');
        const reset = document.getElementById('reset1');
        const usePoint = document.getElementById('usePoint1');
        const pointLimitHP = @json($pointLimitHP);
        const userPoint = @json($userPoint);
        let buyCount = Math.trunc(userPoint / 300) - 1;
        
        //ボタンが押されたらカウント増
        if(buyCount <= 0) {
            upbutton.setAttribute("disabled", true);
        }
        upbutton.addEventListener('click', (event) => {
            //上限を超えないようにする
            if(text.value < pointLimitHP && buyCount > 0) {
                text.value++;
                buyCount--;
                downbutton.removeAttribute("disabled");
                if(buyCount <= 0) {
                    upbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) + 300;
        })
        
        //ボタンが押されたらカウント減
        downbutton.setAttribute("disabled", true);
    
        downbutton.addEventListener('click', (event) => {
            //0以下にはならないようにする
            if(text.value >= 2) {
                text.value--;
                buyCount++;
                upbutton.removeAttribute("disabled");
                if(text.value < 2) {
                    buyCount = Math.trunc(userPoint / 300) - 1;
                    downbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) - 300;
        });
    })();
</script>

<script>
    (() => {
    //HTMLのid値を使って以下のDOM要素を取得
        const downbutton = document.getElementById('down2');
        const upbutton = document.getElementById('up2');
        const text = document.getElementById('textbox2');
        const reset = document.getElementById('reset2');
        const usePoint = document.getElementById('usePoint2');
        const pointLimitMP = @json($pointLimitMP);
        const userPoint = @json($userPoint);
        let buyCount = Math.trunc(userPoint / 300) - 1;
        
        //ボタンが押されたらカウント増
        if(buyCount <= 0) {
            upbutton.setAttribute("disabled", true);
        }
        upbutton.addEventListener('click', (event) => {
            //上限を超えないようにする
            if(text.value < pointLimitMP && buyCount > 0) {
                text.value++;
                buyCount--;
                downbutton.removeAttribute("disabled");
                if(buyCount <= 0) {
                    upbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) + 300;
        })
        
        //ボタンが押されたらカウント減
        downbutton.setAttribute("disabled", true);
    
        downbutton.addEventListener('click', (event) => {
            //0以下にはならないようにする
            if(text.value >= 2) {
                text.value--;
                buyCount++;
                upbutton.removeAttribute("disabled");
                if(text.value < 2) {
                    buyCount = Math.trunc(userPoint / 300) - 1;
                    downbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) - 300;
        });
    })();
</script>

<script>
    (() => {
    //HTMLのid値を使って以下のDOM要素を取得
        const downbutton = document.getElementById('down3');
        const upbutton = document.getElementById('up3');
        const text = document.getElementById('textbox3');
        const reset = document.getElementById('reset3');
        const usePoint = document.getElementById('usePoint3');
        const pointLimitScoreUp = @json($pointLimitScoreUp);
        const userPoint = @json($userPoint);
        let buyCount = Math.trunc(userPoint / 300) - 1;
        
        //ボタンが押されたらカウント増
        if(buyCount <= 0) {
            upbutton.setAttribute("disabled", true);
        }
        upbutton.addEventListener('click', (event) => {
            //上限を超えないようにする
            if(text.value < pointLimitScoreUp && buyCount > 0) {
                text.value++;
                buyCount -= 1;
                downbutton.removeAttribute("disabled");
                if(buyCount <= 0) {
                    upbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) + 300;
        })
        
        //ボタンが押されたらカウント減
        downbutton.setAttribute("disabled", true);
    
        downbutton.addEventListener('click', (event) => {
            //0以下にはならないようにする
            if(text.value >= 2) {
                text.value--;
                buyCount += 1;
                upbutton.removeAttribute("disabled");
                if(text.value < 2) {
                    buyCount = Math.trunc(userPoint / 300) - 1;
                    downbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) - 300;
        });
    })();
</script>

<script>
    (() => {
    //HTMLのid値を使って以下のDOM要素を取得
        const downbutton = document.getElementById('down4');
        const upbutton = document.getElementById('up4');
        const text = document.getElementById('textbox4');
        const reset = document.getElementById('reset4');
        const usePoint = document.getElementById('usePoint4');
        const pointLimitPointUp = @json($pointLimitPointUp);
        const userPoint = @json($userPoint);
        let buyCount = Math.trunc(userPoint / 300) - 1;
        
        //ボタンが押されたらカウント増
        if(buyCount <= 0) {
            upbutton.setAttribute("disabled", true);
        }
        upbutton.addEventListener('click', (event) => {
            //上限を超えないようにする
            if(text.value < pointLimitPointUp && buyCount > 0) {
                text.value++;
                buyCount -= 1;
                downbutton.removeAttribute("disabled");
                if(buyCount <= 0) {
                    upbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) + 300;
        })
        
        //ボタンが押されたらカウント減
        downbutton.setAttribute("disabled", true);
    
        downbutton.addEventListener('click', (event) => {
            //0以下にはならないようにする
            if(text.value >= 2) {
                text.value--;
                buyCount += 1;
                upbutton.removeAttribute("disabled");
                if(text.value < 2) {
                    buyCount = Math.trunc(userPoint / 300) - 1;
                    downbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) - 300;
        });
    })();
</script>

<script>
    (() => {
    //HTMLのid値を使って以下のDOM要素を取得
        const downbutton = document.getElementById('down5');
        const upbutton = document.getElementById('up5');
        const text = document.getElementById('textbox5');
        const reset = document.getElementById('reset5');
        const usePoint = document.getElementById('usePoint5');
        const pointLimitHiMP = @json($pointLimitHiMP);
        const userPoint = @json($userPoint);
        let buyCount = Math.trunc(userPoint / 300) - 1;
        
        //ボタンが押されたらカウント増
        if(buyCount <= 0) {
          upbutton.setAttribute("disabled", true);
        }
        upbutton.addEventListener('click', (event) => {
            //上限を超えないようにする
            if(text.value < pointLimitHiMP && buyCount > 0) {
                text.value++;
                buyCount -= 1;
                downbutton.removeAttribute("disabled");
                if(buyCount <= 0) {
                    upbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) + 300;
        })
        
        //ボタンが押されたらカウント減
        downbutton.setAttribute("disabled", true);
    
        downbutton.addEventListener('click', (event) => {
            //0以下にはならないようにする
            if(text.value >= 2) {
                text.value--;
                buyCount += 1;
                upbutton.removeAttribute("disabled");
                if(text.value < 2) {
                    buyCount = Math.trunc(userPoint / 300) - 1;
                    downbutton.setAttribute("disabled", true);
                }
            }
            
            usePoint.value = parseInt(usePoint.value) - 300;
        });
    })();
</script>
@endsection