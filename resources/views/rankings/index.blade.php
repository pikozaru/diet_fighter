@extends('layouts.ranking_app')

@section('ranking_content')
<h2 class="mx-auto text-center under mt-4 mb-4" style="width:9em">ランキング</h2>

<ul class="nav justify-content-center nav-pills text-center">
    <li class="nav-item">
        <a href="#quest" class="nav-link active" data-toggle="tab" style="border-radius:20px 0 0 0; border: 1px solid #ffcb42;">クエスト</a>
    </li>
    <li class="nav-item">
        <a href="#total" class="nav-link" data-toggle="tab" style="border-radius:0 20px 0 0; border: 1px solid #ffcb42;">総合</a>
    </li>
</ul>

<div class="card mb-1">
    <div class="card-body shadow-sm">
        <div class="tab-content">
            <div id="quest" class="tab-pane active">
                
                <select class="form-control mb-4 text-center" id="sample" onchange="viewChange();" style="width:100px; margin: 0 0 0 auto;">
                    <option value="select1">7日間</option>
                    <option value="select2">14日間</option>
                    <option value="select3">30日間</option>
                </select>
                
                <div id="Box1">
                    <div class="text-center">
                        <h4 class="list-arrow-sub mb-4">あなたのスコア</h4>
                        <div style="overflow-x: auto;">
                            <table class="table">
                                <tr>
                                    <th class="th">順位</th>
                                    <th class="th">レベル</th>
                                    <th class="th">スコア</th>
                                    <th class="th" style="width:25vw;">開始日</th>
                                </tr>
                                <div class="d-flex align-items-center">
                                    @if($userRankingScore7 == null)
                                        <tr>
                                            <td class="text-center">記録なし</td>
                                        </tr>
                                    @else
                                        <tr style="background-color:#f8f8f8;">
                                            <th class="rank">{{$userRank7 + 1}}</th>
                                            <td>{{$userRankingScore7->level}}</td>
                                            <td>{{$userRankingScore7->score}}</td>
                                            <td>{{$userRankingScore7->start_at->format('Y/n/d')}}</td>
                                        </tr>
                                    @endif
                                </div>
                            </table>
                        </div>
                    </div>
            
                    <div class="text-center">
                        <h4 class="text-center mt-5 mb-4 list-arrow-sub">みんなのスコア</h4>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="table text-center position-relative" style="right:10px; border:none;">
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42">順位</th>
                                @if($rankingScoresFilter7 !== null)
                                    @foreach($rankingScoresFilter7 as $rankingScore7)
                                        <th class="rank" style="border:none;">{{$ranking7++}}</th>
                                    @endforeach
                                @endif
                                <td style="border:none;"></td>
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">ユーザー名</th>
                                @if($rankingScoresFilter7 !== null)    
                                    @foreach($rankingScoresFilter7 as $rankingScore7)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore7->user->name}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">Lv</th>
                                @if($rankingScoresFilter7 !== null)    
                                    @foreach($rankingScoresFilter7 as $rankingScore7)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore7->level}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">スコア</th>
                                @if($rankingScoresFilter7 !== null)    
                                    @foreach($rankingScoresFilter7 as $rankingScore7)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore7->score}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">開始日</th>
                                @if($rankingScoresFilter7 !== null)    
                                    @foreach($rankingScoresFilter7 as $rankingScore7)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore7->start_at->format('Y/n/d')}}</td>
                                    @endforeach
                                @endif
                            </tr>
                        </table>
                    </div>
                    <p class="text-center heading-color mt-3">※スコアが0の場合、ランキングに乗りません。</p>
                </div>
                <div id="Box2" style="display:none;">
                    <div class="text-center">
                        <h4 class="list-arrow-sub mb-4">あなたのスコア</h4>
                        
                        <div style="overflow-x: auto;">
                            <table class="table">
                                <tr>
                                    <th class="th">順位</th>
                                    <th class="th">レベル</th>
                                    <th class="th">スコア</th>
                                    <th class="th" style="width:25vw;">開始日</th>
                                </tr>
                                <div class="d-flex align-items-center">
                                    @if($userRankingScore14 == null)
                                        <tr>
                                            <td class="text-center">記録なし</td>
                                        </tr>
                                    @else
                                        <tr style="background-color:#f8f8f8;">
                                            <th class="rank">{{$userRank14 + 1}}</th>
                                            <td>{{$userRankingScore14->level}}</td>
                                            <td>{{$userRankingScore14->score}}</td>
                                            <td>{{$userRankingScore14->start_at->format('Y/n/d')}}</td>
                                        </tr>
                                    @endif
                                </div>
                            </table>
                        </div>
                    </div>
            
                    <div class="text-center">
                        <h4 class="text-center mt-5 mb-4 list-arrow-sub">みんなのスコア</h4>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="table text-center position-relative" style="right:10px; border:none;">
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42">順位</th>
                                @if($rankingScoresFilter14 !== null)
                                    @foreach($rankingScoresFilter14 as $rankingScore14)
                                        <th class="rank" style="border:none;">{{$ranking14++}}</th>
                                    @endforeach
                                @endif
                                <td style="border:none;"></td>
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">ユーザー名</th>
                                @if($rankingScoresFilter14 !== null)    
                                    @foreach($rankingScoresFilter14 as $rankingScore14)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore14->user->name}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">Lv</th>
                                @if($rankingScoresFilter14 !== null)    
                                    @foreach($rankingScoresFilter14 as $rankingScore14)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore14->level}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">スコア</th>
                                @if($rankingScoresFilter14 !== null)    
                                    @foreach($rankingScoresFilter14 as $rankingScore14)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore14->score}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">開始日</th>
                                @if($rankingScoresFilter14 !== null)
                                    @foreach($rankingScoresFilter14 as $rankingScore14)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore14->start_at->format('Y/n/d')}}</td>
                                    @endforeach
                                @endif
                            </tr>
                        </table>
                    </div>
                    <p class="text-center heading-color mt-3">※スコアが0の場合、ランキングに乗りません。</p>
                </div>
                <div id="Box3" style="display:none;">
                    <div class="text-center">
                        <h4 class="list-arrow-sub mb-4">あなたのスコア</h4>
                    
                        <div style="overflow-x: auto;">
                            <table class="table">
                                <tr>
                                    <th class="th">順位</th>
                                    <th class="th">レベル</th>
                                    <th class="th">スコア</th>
                                    <th class="th" style="width:25vw;">開始日</th>
                                </tr>
                                <div class="d-flex align-items-center">
                                    @if($userRankingScore30 == null)
                                        <tr>
                                            <td class="text-center">記録なし</td>
                                        </tr>
                                    @else
                                        <tr style="background-color:#f8f8f8;">
                                            <th class="rank">{{$userRank30 + 1}}</th>
                                            <td>{{$userRankingScore30->level}}</td>
                                            <td>{{$userRankingScore30->score}}</td>
                                            <td>{{$userRankingScore30->start_at->format('Y/n/d')}}</td>
                                        </tr>
                                    @endif
                                </div>
                            </table>
                        </div>
                    </div>
            
                    <div class="text-center">
                        <h4 class="text-center mt-5 mb-4 list-arrow-sub">みんなのスコア</h4>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="table text-center position-relative" style="right:10px; border:none;">
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42">順位</th>
                                @if($rankingScoresFilter30 !== null)    
                                    @foreach($rankingScoresFilter30 as $rankingScore30)
                                        <th class="rank" style="border:none;">{{$ranking30++}}</th>
                                    @endforeach
                                @endif
                                <td style="border:none;"></td>
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">ユーザー名</th>
                                @if($rankingScoresFilter30 !== null)    
                                    @foreach($rankingScoresFilter30 as $rankingScore30)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore30->user->name}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">Lv</th>
                                @if($rankingScoresFilter30 !== null)    
                                    @foreach($rankingScoresFilter30 as $rankingScore30)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore30->level}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">スコア</th>
                                @if($rankingScoresFilter30 !== null)    
                                    @foreach($rankingScoresFilter30 as $rankingScore30)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore30->score}}</td>
                                    @endforeach
                                @endif
                            </tr>
                            <tr style="border:none;">
                                <th class="th fixed01" style="border:none; border-right: 2px solid #ffcb42;">開始日</th>
                                @if($rankingScoresFilter30 !== null)    
                                    @foreach($rankingScoresFilter30 as $rankingScore30)
                                        <td style="background-color:#f8f8f8; border:none; border-left: 2px solid #ffcb42;">{{$rankingScore30->start_at->format('Y/n/d')}}</td>
                                    @endforeach
                                @endif
                            </tr>
                        </table>
                    </div>
                    <p class="text-center heading-color mt-3">※スコアが0の場合、ランキングに乗りません。</p>
                </div>
                
                <script>
                    function viewChange(){
                        if(document.getElementById('sample')){
                            id = document.getElementById('sample').value;
                            if(id == 'select1'){
                                document.getElementById('Box1').style.display = "";
                                document.getElementById('Box2').style.display = "none";
                                document.getElementById('Box3').style.display = "none";
                            }else if(id == 'select2'){
                                document.getElementById('Box1').style.display = "none";
                                document.getElementById('Box2').style.display = "";
                                document.getElementById('Box3').style.display = "none";
                            }
                            else if(id == 'select3'){
                                document.getElementById('Box1').style.display = "none";
                                document.getElementById('Box2').style.display = "none";
                                document.getElementById('Box3').style.display = "";
                            }
                        }
                    
                    window.onload = viewChange;
                    }
                </script>
            </div>
            <div id="total" class="tab-pane">
                <div class="text-center">
                    <h4 class="list-arrow-sub mb-4">あなたのスコア</h4>
                
                    <div style="overflow-x: auto;">
                        <table class="table">
                            <tr>
                                <th class="th">順位</th>
                                <th class="th">ランク</th>
                                <th class="th">総合スコア</th>
                            </tr>
                            <div class="d-flex align-items-center">
                                @if($userRankingScoreTotal == null)
                                    <tr>
                                        <td class="text-center">記録なし</td>
                                    </tr>
                                @else
                                    <tr style="background-color:#f8f8f8;">
                                        <th class="rank">{{$userRankTotal + 1}}</th>
                                        <td>{{$userRankingScoreTotal->rank}}</td>
                                        <td>{{$userRankingScoreTotal->total_score}}</td>
                                    </tr>
                                @endif
                            </div>
                        </table>
                    </div>
                </div>
                
                <div class="text-center">
                    <h4 class="text-center mt-3 mb-4 list-arrow-sub">総合スコア</h4>
                
                    <div style="height:300px; overflow-x: hidden; overflow-y: scroll; border-top: 5px solid #ffcb42;">
                        <table class="table" style="border:none;">
                            <tr style="border:none;">
                                <th class="th fixed02" style="border:none;">順位</th>
                                <th class="th fixed02" style="border:none;">ユーザー名</th>
                                <th class="th fixed02" style="border:none;">ランク</th>
                                <th class="th fixed02" style="border:none;">総合スコア</th>
                            </tr>
                            <div class="d-flex align-items-center">
                                @if($rankingTotalScores !== null)
                                    @foreach($rankingTotalScores as $user)
                                        <tr style="border:none;">
                                            <th class="rank">{{$totalRanking++}}</th>
                                            <td style="background-color:#f8f8f8; border:none; border-bottom: 2px solid #ffcb42;">{{$user->name}}</td>
                                            <td style="background-color:#f8f8f8; border:none; border-bottom: 2px solid #ffcb42;">{{$user->rank}}</td>
                                            <td style="background-color:#f8f8f8; border:none; border-bottom: 2px solid #ffcb42;">{{$user->total_score}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </div>
                        </table>
                    </div>
                    <p class="heading-color mt-3">※総合スコアが0の場合、ランキングに乗りません。</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection