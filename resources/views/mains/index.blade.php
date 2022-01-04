@extends('layouts.main_app')

@section('main_content')
    <div class="mt-1 mb-2">
        <div class="card mb-1">
            <div class="card-body shadow-sm">
                <div class="container">
                    @if($record == null)
                        <h4 class="text-center heading-color under mb-3">記録なし</h4>
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-3 text-center">
                                <p class="heading-color">BMI</p>
                                <b class="side-number">--</b>
                                <p style="font-size:15px;"></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="heading-color">体重</p>
                                <b class="weight-number">--</b>
                                <b style="unit">kg</b>
                            </div>
                            <div class="col-3 text-center">
                                <p class="heading-color">体脂肪率</p>
                                <b class="side-number">--</b>
                                <b style="font-size:15px;">%</b>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="button" class="diet-button diet-button-enter w-50 mb-4" data-toggle="modal" data-target="#create">入力する</button>
                        </div>
                                
                        <!-- モーダル -->
                        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="/mains/store">
                                        {{ csrf_field() }}
                                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                            <h4>記録画面</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="list-arrow-sub">体重を入力</p>
                                            <br>
                                            <input class="input-number w-25 mb-5" type="number" name="weight" min="35" max="200" step="0.01" required><b> kg</b>
                                            <br>
                                            <p class="list-arrow-sub">体脂肪率を入力(任意)</p>
                                            <br>
                                            <input class="input-number w-25" type="number" name="body_fat_percentage" max="50" step="0.1" style="width:90px;"><b> %</b>
                                        </div>
                                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                            <button type="button" class="diet-button diet-button-back" data-dismiss="modal">戻る</button>
                                            <button type="submit" class="diet-button diet-button-enter">確定する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($recordRecently === $carbonJapaneseNotation)
                        <h4 class="text-center heading-color under mb-3">Today</h4>
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-3 text-center">
                                <p class="heading-color">BMI</p>
                                <b class="side-number">{{$record->bmi}}</b>
                                <p style="font-size:15px;"></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="heading-color">体重</p>
                                <b class="weight-number">{{$record->weight}}</b>
                                <b class="unit">kg</b>
                            </div>
                            <div class="col-3 text-center">
                                <p class="heading-color">体脂肪率</p>
                                @if($record == null or $record->body_fat_percentage == null)
                                    <b class="side-number">--</b>
                                @else
                                    <b class="side-number">{{$record->body_fat_percentage}}</b>
                                @endif
                                <b style="font-size:15px;">%</b>
                            </div>
                        </div>
                        
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-3 text-center">
                                @if($bmiSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$bmiSub}}</b>
                                @elseif($bmiSub == 0)
                                    <b class="heading-color number-sub">±0</b>
                                @elseif($bmiSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$bmiSub}}</b>
                                @endif
                            </div>
                            <div class="col-6 text-center">
                                @if($weightSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$weightSub}}kg</b>
                                @elseif($weightSub == 0)
                                    <b class="heading-color number-sub">±0kg</b>
                                @elseif($weightSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$weightSub}}kg</b>
                                @endif
                            </div>
                            <div class="col-3 text-center">
                                @if($bodyFatPercentageSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$bodyFatPercentageSub}}%</b>
                                @elseif($bodyFatPercentageSub == 0)
                                    <b class="heading-color number-sub">±0%</b>
                                @elseif($bodyFatPercentageSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$bodyFatPercentageSub}}%</b>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">    
                            <h5 class="list-arrow-sub">アクションポイント</h5>
                            <p><b class="mr-1" style="font-size:30px;">{{$record->get_action_point}}</b>GET</p>
                        </div>
                        
                        <div class="text-center">
                            <button type="button" class="diet-button diet-button-enter w-75 mt-3 mb-2" data-toggle="modal" data-target="#edit">変更する</button>
                        </div>
                                    
                        <!-- モーダル -->
                        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="/mains/update">
                                        {{ csrf_field() }}
                                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                            <h4>記録変更画面</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="list-arrow-sub">体重を入力</p>
                                            <br>
                                            <input class="input-number mb-5" type="number" name="weight" min="35" max="200" step="0.01" style="width:90px;" required> kg
                                            <br>
                                            <p class="list-arrow-sub">体脂肪率を入力</p>
                                            <br>
                                            <input class="input-number" type="number" name="body_fat_percentage" max="50" step="0.01" style="width:90px;" required> %
                                        </div>
                                        
                                        <div class="text-center">
                                            <p style="font-size:12px; color:#EF454A;">※アクションポイントは変更されません。</p>
                                        </div>
                                        
                                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                            <button type="button" class="diet-button diet-button-back" data-dismiss="modal">戻る</button>
                                            <button type="submit" class="diet-button diet-button-enter">変更する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($recordRecently !== $carbonJapaneseNotation)
                        <h4 class="text-center heading-color under mb-3">Last Time</h4>
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-3 text-center">
                                <p class="heading-color">BMI</p>
                                <b class="side-number">{{$record->bmi}}</b>
                                <p style="font-size:15px;"></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="heading-color">体重</p>
                                <b class="weight-number">{{$record->weight}}</b>
                                <b class="unit">kg</b>
                            </div>
                            <div class="col-3 text-center">
                                <p class="heading-color">体脂肪率</p>
                                @if($record == null or $record->body_fat_percentage == null)
                                    <b class="side-number">--</b>
                                @else
                                    <b class="side-number">{{$record->body_fat_percentage}}</b>
                                @endif
                                <b style="font-size:15px;">%</b>
                            </div>
                        </div>
                        
                        <div class="row justify-content-center d-flex align-items-start">
                            <div class="col-3 text-center">
                                @if($bmiSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$bmiSub}}</b>
                                @elseif($bmiSub == 0)
                                    <b class="heading-color number-sub">±0</b>
                                @elseif($bmiSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$bmiSub}}</b>
                                @endif
                            </div>
                            <div class="col-6 text-center">
                                @if($weightSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$weightSub}}kg</b>
                                @elseif($weightSub == 0)
                                    <b class="heading-color number-sub">±0kg</b>
                                @elseif($weightSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$weightSub}}kg</b>
                                @endif
                            </div>
                            <div class="col-3 text-center">
                                @if($bodyFatPercentageSub > 0)
                                    <b class="number-sub" style="color: #EF454A;">+{{$bodyFatPercentageSub}}%</b>
                                @elseif($bodyFatPercentageSub == 0)
                                    <b class="heading-color number-sub">±0%</b>
                                @elseif($bodyFatPercentageSub < 0)
                                    <b class="number-sub" style="color: #66cdaa;">{{$bodyFatPercentageSub}}%</b>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">    
                            <h5 class="list-arrow-sub">アクションポイント</h5>
                            <p><b class="mr-1" style="font-size:30px;">{{$record->get_action_point}}</b>GET</p>
                        </div>
                        
                        <div class="text-center">
                            <button type="button" class="diet-button diet-button-enter w-75 mt-3 mb-2" data-toggle="modal" data-target="#create">入力する</button>
                        </div>
                                
                        <!-- モーダル -->
                        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="/mains/store">
                                        {{ csrf_field() }}
                                        <div class="text-center mt-4 mb-2 pb-1" style="border-bottom: 2.1px solid #e8e8e8;" id="label1">
                                            <h4>記録画面</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="list-arrow-sub">体重を入力</p>
                                            <br>
                                            <input class="input-number w-25 mb-5" type="number" name="weight" min="35" max="200" step="0.01" required><b> kg</b>
                                            <br>
                                            <p class="list-arrow-sub">体脂肪率を入力(任意)</p>
                                            <br>
                                            <input class="input-number w-25" type="number" name="body_fat_percentage" max="50" step="0.1" style="width:90px;"><b> %</b>
                                        </div>
                                        <div class="modal-footer" style="border-top: 2.1px solid #e8e8e8;">
                                            <button type="button" class="diet-button diet-button-back" data-dismiss="modal">戻る</button>
                                            <button type="submit" class="diet-button diet-button-enter">確定する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <ul class="nav nav-pills justify-content-center mt-4 text-center">
            <li class="nav-item">
                <a href="#w1w" class="nav-link active" data-toggle="tab" style="border-radius:10px 0 0 10px; border: 1px solid #ffcb42;">7日間</a>
            </li>
            <li class="nav-item">
                <a href="#w1m" class="nav-link" data-toggle="tab" style="border-radius:0 10px 10px 0; border: 1px solid #ffcb42;">30日間</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="w1w" class="tab-pane active">
        
                <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                	<canvas id="WeightChart"></canvas>
                </div>
                 
                <script>//以下がグラフデータ
                	var postAt = @json($postAt);
                	var weight = @json($weight);
                    postAt.reverse();
                    weight.reverse();
                    
                	var ctx = document.getElementById('WeightChart').getContext('2d');
                	var chart = new Chart(ctx, {
                		type: 'line',//グラフの種類
                		data: {
                			labels: postAt,
                			datasets: [{
                				data: weight,
                				backgroundColor: 'rgb(255, 99, 132, 0.3)',
                				borderColor: 'rgb(255, 99, 132)',
                			}]
                		},
                		options: {
                		    legend: {
                                display: false
                            },
                            
                            tooltips:{
                                callbacks:{
                                    label: function(tooltipItems, data) {
                                        if(tooltipItems.yLabel == "0"){
                                            return "";
                                        }
                                        return "：" + tooltipItems.yLabel + "kg";
                                    }
                                }
                              
                            },
                            
                            scales:{
                                yAxes:[{
                                    ticks:{
                                        callback: function(value){
                                        return  value +  'kg'    
                                        }
                                    }
                                }]
                            },
                		
                			maintainAspectRatio: false
                		}
                	});
                </script>
            </div>
            <div id="w1m" class="tab-pane horizontal-list">
        
                <div class="chart-container chart-width">
                	<canvas id="MonthWeightChart"></canvas>
                </div>
                 
                <script>//以下がグラフデータ
                	var mPostAt = @json($mPostAt);
                	var mWeight = @json($mWeight);
                    mPostAt.reverse();
                    mWeight.reverse();
                    
                	var ctx = document.getElementById('MonthWeightChart').getContext('2d');
                	var chart = new Chart(ctx, {
                		type: 'line',//グラフの種類
                		data: {
                			labels: mPostAt,
                			datasets: [{
                				data: mWeight,
                				backgroundColor: 'rgb(255, 99, 132, 0.3)',
                				borderColor: 'rgb(255, 99, 132)'
                			}]
                		},
                		options: {
                		    legend: {
                                display: false
                            },
                            
                            tooltips:{
                                callbacks:{
                                    label: function(tooltipItems, data) {
                                        if(tooltipItems.yLabel == "0"){
                                            return "";
                                        }
                                        return "：" + tooltipItems.yLabel + "kg";
                                    }
                                }
                              
                            },
                            
                            scales:{
                                yAxes:[{
                                    ticks:{
                                        callback: function(value){
                                        return  value +  'kg'    
                                        }
                                    }
                                }]
                            },
                		
                			maintainAspectRatio: false
                		}
                	});
                </script>
            </div>
        </div>
        
    </div>
    
    <div class="card mb-1">
        <div class="card-body shadow-sm">
            <div class="text-center">
                <h4 class="under mb-3">現在のランク</h4>
                <h1 style="font-size:40px;">{{$user->rank}}</h1>
                <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
                <div class="mx-auto" id="container"></div>
                <p class="list-arrow-sub">次のランクまで：{{$requiredExp}}</p>
            </div>
        </div>
    </div>
    
    <script>
        var exp = @json($exp);
        var bar = new ProgressBar.Line(container, {
          strokeWidth: 3,
          easing: 'easeInOut',
          duration: 1400,
          color: '#66cdaa',
          trailColor: '	#999999',
          trailWidth: 3,
          svgStyle: null,
          text: {
            style: {
              // Text color.
              // Default: same as stroke color (options.color)
              color: '#999',
              position: 'absolute',
              right: '0',
              top: '30px',
              padding: 0,
              margin: 0,
              transform: null
            },
            autoStyleContainer: false
          },
          from: {color: '#FFEA82'},
          to: {color: '#ED6A5A'},
        });
        
        bar.animate(exp);
    </script>

    @if($quest !== null)
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title under mb-3">中断したクエスト</h4>
                
                <div class="text-center">
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
                    
                    <div class="text-center">
                        <p class="list-arrow-sub">期間：{{$quest->value}}日</p>
                        <br>
                        <p class="list-arrow-sub">開始日：{{$quest->start_at->format('Y/n/d H時i分')}}</p>
                        <br>
                        <p class="list-arrow-sub">終了日：{{$quest->end_at->format('Y/n/d H時i分')}}</p>
                    </div>
                    <div class="text-center">
                        <a class="btn diet-button diet-button-enter w-50 mt-4" href="{{ route('quests.create') }}">再開</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
           
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
@endsection