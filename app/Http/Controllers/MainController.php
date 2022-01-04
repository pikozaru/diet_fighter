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
        $possessionItems = PossessionItem::where('user_id', Auth::id())->count();
        $items = Item::all();
        
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
        $recordLastTime = Record::where('user_id', Auth::id())->orderBy('created_at', 'desc')->skip(1)->first();
        
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
        $quest = Quest::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        if($record !== null) {
            $recordRecently = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('post_at')->format('Y/m/d');
        }
        
        $carbon = Carbon::now();
        $carbonJapaneseNotation = Carbon::now()->format('Y/m/d');
        $nextrank = self::calcurateRank($user->rank);
        
        $exp = $user->total_score / $nextrank;
        $requiredExp = $nextrank - $user->total_score;
        $nowHP = 0;
        $nowMP = 0;
        if($quest !== null) {
            $nowHP = $quest->hit_point / $quest->max_hit_point;
            $nowMP = $quest->magical_point / $quest->max_magical_point;
        }
        
        $weekRecords = Record::whereDate('created_at', '>', now()->subWeek())->latest()->get();
        $monthRecords = Record::whereDate('created_at', '>', now()->subMonth())->latest()->get();
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
        
        $nowExp = 0;
        $subExp = 0;
        if($quest !== null) {
            $nowExp = $quest->exp / self::calcurateRequiredLevel($quest->level);
            $subExp = self::calcurateRequiredLevel($quest->level) - $quest->exp;
        }
        
        return view('mains.index', compact('record', 'recordLastTime', 'weightSub', 'bodyFatPercentageSub', 'bmiSub', 'recordRecently', 'quest', 'user', 'carbon', 'carbonJapaneseNotation', 'exp', 'requiredExp', 'nowHP', 'nowMP', 'postAt', 'weight', 'mPostAt', 'mWeight', 'nowExp', 'subExp'));
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $recordRecently = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('post_at');
        $carbonJapaneseNotation = Carbon::now();
        $recordId = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('id');
        if($recordRecently === $carbonJapaneseNotation) {
            return redirect()->route('mains.index', ['main' => $recordId]);
        }
        
        $record = new Record();
        $record->user_id = Auth::id();
        $record->weight = $request->input('weight');
        $record->body_fat_percentage = $request->input('body_fat_percentage');
        $userHeight = $user->height / 100;
        $record->bmi = round($record->weight / ($userHeight * $userHeight), 1);
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $record->post_at = Carbon::now();
        $record->save();
        
        $recordSkip1Get = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->skip(1)->first();
        $recordGetActionPoint = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        if($recordSkip1Get !== null) {
            $recordGetActionPoint->get_action_point = calcurateActionPoint($recordGetActionPoint - $recordSkip1Get, $record->weight);
            if(calcurateActionPoint($recordGetActionPoint - $recordSkip1Get, $record->weight) < 50) {
                $recordGetActionPoint->get_action_point = 50;
            } elseif(calcurateActionPoint($recordGetActionPoint - $recordSkip1Get, $record->weight) > 150) {
                $recordGetActionPoint->get_action_point = 150;
            }
        } else {
            $recordGetActionPoint->get_action_point = 100;
        }
        
        $recordGetActionPoint->save();
        
        $quest = Quest::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        if($quest !== null and $carbonJapaneseNotation < $quest->end_at) {
            $quest->action_point += $recordGetActionPoint->get_action_point;
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
        $recordRecently = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('post_at');
        $carbonJapaneseNotation = Carbon::now();
        $recordId = Record::where('user_id', Auth::id())->orderBy('id', 'desc')->value('id');
        if($recordRecently === $carbonJapaneseNotation) {
            return redirect()->route('mains.index', ['main' => $recordId]);
        }
        
        $record = Record::orderBy('id', 'desc')->first();
        $record->weight = $request->input('weight');
        $record->body_fat_percentage = $request->input('body_fat_percentage');
        $userHeight = $user->height / 100;
        $record->bmi = round($record->weight / ($userHeight * $userHeight), 1);
        $record->post_at = Carbon::now();
        $record->save();
        
        return redirect()->route('mains.index', ['main' => $record->id]);
    }

    private static function calcurateActionPoint($subWeight, $nowWeight)
    {
        $base_action_point = 100;
        
        $nowWeight_multiple -= $nowWeight * 0.3;
        $multiple = (100 - $nowWeight_multiple);
        $action_point = $base_action_point - ($subWeight * $multiple);
        
        return floor($action_point);
    }
    
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
    
    private static function calcurateRank($rank)
    {
        $rankUpPoint = 1000;
        $rate = 1.2;
        $scoreToExp = 0;
        
        for ($i = 0; $i < $rank; $i++) {
            $scoreToExp += $rankUpPoint * ($rate ** ($i));
        }

        return floor($scoreToExp);
    }

}
