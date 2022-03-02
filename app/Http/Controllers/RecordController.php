<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\PossessionSkills;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    // フィルター解除処理
    public function latest()
    {
        $user = Auth::user();
        $carbon = Carbon::now();
        $user->filtering_month = $carbon->month;
        $user->filtering_year = $carbon->year;
        $user->save();
        
        return redirect()->route('records.index');
    }
    
    
    // 記録一覧
    public function index()
    {
        $user = Auth::user();
        $carbon = Carbon::now();
        $records = Record::where('user_id', Auth::id())->orderBy('post_at', 'asc')->get();
        $postAtMonthOnly = [];
        
        foreach($records as $record){
            $postAtMonthOnly[] = $record;
        }
        
        return view('records.index', compact('records', 'user', 'carbon', 'postAtMonthOnly'));
    }
    
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $carbon = Carbon::now();
        $carbonFilteringDate = new Carbon($user->filtering_date);
        
        if($request->input('month')) {
            $user->filtering_month = $request->input('month') + 1;
            
            if($request->input('month') + 1 > $carbon->format('n')) {
                $user->filtering_month = $carbon->format('n');
            }
        }
        
        if($request->input('year')) {
            $user->filtering_year = $request->input('year');
            
            if($request->input('year') > $carbon->format('Y')) {
                $user->filtering_year = $carbon->format('Y');
            }
        }
        
        if($request->get('previous')) {
            $user->filtering_month -= 1;
            $user->save();
        } elseif($request->get('next')) {
            $user->filtering_month += 1;
            $user->save();
        }
        
        if($user->filtering_month <= 0) {
            $user->filtering_year -= 1;
            $user->filtering_month = 12;
        } elseif($user->filtering_month >= 13) {
            $user->filtering_year += 1;
            $user->filtering_month = 1;
        }
        
        if($request->input('month') == "0") {
            $user->filtering_month = 1;
        }
        
        $user->save();
        
        return redirect()->route('records.index');
    }
    
    
    // その日の記録
    public function show(Record $record)
    {
        $user = Auth::user();
        $recordNow = Record::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $recordLastTime = Record::where('user_id', Auth::id())->whereBetween('id', [1, $record->id])->orderBy('created_at', 'desc')->skip(1)->first();
        
        if($recordLastTime == null) {
            $weightSub = "--";
            $bodyFatPercentageSub = "--";
            $bmiSub = "--";
        } else {
            $weightSub = round($record->weight - $recordLastTime->weight, 2);
            $bodyFatPercentageSub = round($record->body_fat_percentage - $recordLastTime->body_fat_percentage ,1);
            $bmiSub = round($record->bmi - $recordLastTime->bmi, 1);
        }
        
        $weightSubNow = round($record->weight - $recordNow->weight, 2);
        $bodyFatPercentageSubNow = round($record->body_fat_percentage - $recordNow->body_fat_percentage ,1);
        $bmiSubNow = round($record->bmi - $recordNow->bmi, 1);
        
        $carbonJapaneseNotation = Carbon::now()->format('Y/m/d');
        
        return view('records.show', compact('record', 'recordNow', 'weightSub', 'bodyFatPercentageSub', 'bmiSub', 'weightSubNow', 'bodyFatPercentageSubNow', 'bmiSubNow', 'user', 'carbonJapaneseNotation'));
    }
}
