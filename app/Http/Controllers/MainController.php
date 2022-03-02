<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Record;
use App\Models\Quest;
use App\Models\Item;
use App\Models\PossessionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
    */
    
    public function index(Request $request, Record $record)
    {
        // ホーム画面
        $possessionItems = PossessionItem::where('user_id', Auth::id())->count();
        $items = Item::all();
        
        // 登録時に所持できるアイテムを追加出来なかった場合
        if($possessionItems == 0) {
            foreach($items as $item) {
                $addPossessionItemDataBase = new PossessionItem();
                $addPossessionItemDataBase->user_id = Auth::id();
                $addPossessionItemDataBase->item_id = $item->id;
                $addPossessionItemDataBase->save();
            }
        }
        
        $user = Auth::user();
        $record = Record::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        // 前日の記録
        $recordLastTime = Record::where('user_id', Auth::id())->orderBy('created_at', 'desc')->skip(1)->first();
        
        // 記録が初めての場合
        if($recordLastTime == null) {
            $weightSub = "--";
            $bodyFatPercentageSub = "--";
            $bmiSub = "--";
        } else {
            $weightSub = round($record->weight - $recordLastTime->weight ,2);
            $bodyFatPercentageSub = round($record->body_fat_percentage - $recordLastTime->body_fat_percentage ,1);
            $bmiSub = round($record->bmi - $recordLastTime->bmi, 1);
        }
        
        $recordRecently = null;
        if($record !== null) {
            $recordRecently = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('post_at')->format('Y/m/d');
        }
        
        // 現在の日本時間
        $carbonJapaneseNotation = Carbon::now()->format('Y/m/d');
        
        // ランクと経験値を取得
        $nextrank = self::calcurateRequiredRank($user->rank);
        $rankExp = $user->total_score / $nextrank;
        $requiredExp = $nextrank - $user->total_score;
        
        // 進行中のクエスト情報を取得
        $quest = Quest::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $nowHP = 0;
        $nowMP = 0;
        if($quest !== null) {
            $nowHP = $quest->hit_point / $quest->max_hit_point;
            $nowMP = $quest->magical_point / $quest->max_magical_point;
        }
        
        $levelExp = 0;
        $subExp = 0;
        if($quest !== null) {
            $levelExp = $quest->exp / self::calcurateRequiredLevel($quest->level);
            $subExp = self::calcurateRequiredLevel($quest->level) - $quest->exp;
        }
        
        // 一週間、一ヶ月間の情報を取得
        $weekRecords = Record::where('user_id', Auth::id())->whereDate('created_at', '>', now()->subWeek())->latest()->get();
        $monthRecords = Record::where('user_id', Auth::id())->whereDate('created_at', '>', now()->subMonth())->latest()->get();
        $postAt = [];
        $weight = [];
        $mPostAt = [];
        $mWeight = [];
        
        foreach($weekRecords as $weekRecord){
            $postAt[] = $weekRecord->post_at->format('n/d');
            $weight[] = $weekRecord->weight;
        }
        
        foreach($monthRecords as $monthRecord){
            $mPostAt[] = $monthRecord->post_at->format('n/d');
            $mWeight[] = $monthRecord->weight;
        }
        
        return view('mains.index', compact('record', 'recordLastTime', 'weightSub', 'bodyFatPercentageSub', 'bmiSub', 'recordRecently', 'quest', 'user', 'carbonJapaneseNotation', 'rankExp', 'requiredExp', 'nowHP', 'nowMP', 'postAt', 'weight', 'mPostAt', 'mWeight', 'levelExp', 'subExp'));
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // 1日2回以上の記録が残らないようにする
        $user = Auth::user();
        $recordRecently = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('post_at');
        $carbonJapaneseNotation = Carbon::now();
        $recordId = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('id');
        if($recordRecently !== null and $recordRecently->format('n/d') === $carbonJapaneseNotation->format('n/d')) {
            return redirect()->route('mains.index', ['main' => $recordId]);
        }
        
        // 入力された記録を保存
        $record = new Record();
        $record->user_id = Auth::id();
        $record->weight = $request->input('weight');
        $record->body_fat_percentage = $request->input('body_fat_percentage');
        $userHeight = $user->height / 100;
        $record->bmi = round($record->weight / ($userHeight * $userHeight), 1);
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $record->post_at = Carbon::now();
        $record->save();
        
        // 保存された記録からアクションポイントを算出
        $recordSkip1Get = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->skip(1)->first();
        if($recordSkip1Get !== null) {
            $record->get_action_point = self::calcurateActionPoint($recordSkip1Get->weight, $record->weight);
            if(self::calcurateActionPoint($recordSkip1Get->weight, $record->weight) < 50) {
                $record->get_action_point = 50;
            } elseif(self::calcurateActionPoint($recordSkip1Get->weight, $record->weight) > 150) {
                $record->get_action_point = 150;
            }
        } else {
            $record->get_action_point = 100;
        }
        
        $record->save();
        
        // アクションポイントを追加
        $quest = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        if($quest !== null and $carbonJapaneseNotation < $quest->end_at) {
            $quest->action_point += $record->get_action_point;
            $quest->save();
        }
        
        return redirect()->route('mains.index', ['main' => $record->id]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $carbonJapaneseNotation = Carbon::now()->format('n/d');
        
        $record = Record::orderBy('id', 'desc')->first();
        $record->weight = $request->input('weight');
        $record->body_fat_percentage = $request->input('body_fat_percentage');
        $userHeight = $user->height / 100;
        $record->bmi = round($record->weight / ($userHeight * $userHeight), 1);
        $record->post_at = Carbon::now();
        $record->save();
        
        return redirect()->route('mains.index', ['main' => $record->id]);
    }

    // アクションポイントの取得量計算
    private static function calcurateActionPoint($beforeWeight, $nowWeight)
    {
        $baseActionPoint = 100;
        
        $addActionPoint = ($beforeWeight - $nowWeight) * 50;
        $actionPoint = $baseActionPoint + $addActionPoint;
        
        return floor($actionPoint);
    }
    
    // 次のレベルに必要な経験値
    private static function calcurateRequiredLevel($level)
    {
        $level_up_point = 100;
        $rate = 1.1;
        $score = 0;
        
        for ($i = 0; $i < $level; $i++) {
            $score += $level_up_point * ($rate ** ($i));
        }

        return floor($score);
    }
    
    // 次のランクに必要な経験値
    private static function calcurateRequiredRank($rank)
    {
        $rankUpPoint = 500;
        $rate = 1.2;
        $scoreToExp = 0;
        
        for ($i = 0; $i < $rank; $i++) {
            $scoreToExp += $rankUpPoint * ($rate ** ($i));
        }

        return floor($scoreToExp);
    }

}
