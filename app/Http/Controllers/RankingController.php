<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ranking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $carbon = Carbon::now();
        $ranking7 = 1;
        $ranking14 = 1;
        $ranking30 = 1;
        $totalRanking = 1;
        $rankingScores7 = Ranking::where('value', 7)->orderBy('score', 'desc')->get();
        $rankingScores14 = Ranking::where('value', 14)->orderBy('score', 'desc')->get();
        $rankingScores30 = Ranking::where('value', 30)->orderBy('score', 'desc')->get();
        $rankingScoresFilter7 = Ranking::where('value', 7)->orderBy('score', 'desc')->take(10)->get();
        $rankingScoresFilter14 = Ranking::where('value', 14)->orderBy('score', 'desc')->take(10)->get();
        $rankingScoresFilter30 = Ranking::where('value', 30)->orderBy('score', 'desc')->take(10)->get();
        $rankingTotalScores = User::where('total_score', '>' , 0)->orderBy('total_score', 'desc')->take(10)->get();
        $userName7 = [];
        $userName14 = [];
        $userName30 = [];
        $userNameTotal = [];
        
        foreach($rankingScores7 as $rankingScore7) {
            $userName7[] = $rankingScore7->user->name;
        }
        $userRank7 = array_search($user->name, $userName7);
        
        foreach($rankingScores14 as $rankingScore14) {
            $userName14[] = $rankingScore14->user->name;
        }
        $userRank14 = array_search($user->name, $userName14);
        
        foreach($rankingScores30 as $rankingScore30) {
            $userName30[] = $rankingScore30->user->name;
        }
        $userRank30 = array_search($user->name, $userName30);
        
        foreach($rankingTotalScores as $rankingTotalScore) {
            $userNameTotal[] = $rankingTotalScore->name;
        }
        $userRankTotal = array_search($user->name, $userNameTotal);
        
        $userRankingScore7 = Ranking::where('user_id', Auth::id())->where('value', 7)->orderBy('score', 'desc')->first();
        $userRankingScore14 = Ranking::where('user_id', Auth::id())->where('value', 14)->orderBy('score', 'desc')->first();
        $userRankingScore30 = Ranking::where('user_id', Auth::id())->where('value', 30)->orderBy('score', 'desc')->first();
        $userRankingScoreTotal = User::where('id', Auth::id())->orderBy('total_score', 'desc')->first();
        
        return view('rankings.index', compact('carbon', 'ranking7', 'ranking14', 'ranking30', 'totalRanking', 'rankingScoresFilter7', 'rankingScoresFilter14', 'rankingScoresFilter30', 'rankingTotalScores', 'userRank7', 'userRank14', 'userRank30', 'userRankTotal', 'userRankingScore7', 'userRankingScore14', 'userRankingScore30', 'userRankingScoreTotal'));
    }

    
}
