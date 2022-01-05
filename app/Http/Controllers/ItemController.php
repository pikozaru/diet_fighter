<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\PossessionItem;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $possessionItems = PossessionItem::where('user_id', Auth::id())->orderBy('id', 'desc')->get();//where('user_id', Auth::id());
        return view('items.index', compact('items', 'possessionItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $possessionItems = PossessionItem::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        
        $possessionItemHP = PossessionItem::where('user_id', Auth::id())->where('item_id', 1)->first();
        $possessionItemMP = PossessionItem::where('user_id', Auth::id())->where('item_id', 2)->first();
        $possessionItemScoreUp = PossessionItem::where('user_id', Auth::id())->where('item_id', 3)->first();
        $possessionItemPointUp = PossessionItem::where('user_id', Auth::id())->where('item_id', 4)->first();
        $possessionItemHiMP = PossessionItem::where('user_id', Auth::id())->where('item_id', 5)->first();
        
        $pointLimitHP = $possessionItemHP->item->max_possession_number - $possessionItemHP->possession_number;
        $pointLimitMP = $possessionItemMP->item->max_possession_number - $possessionItemMP->possession_number;
        $pointLimitScoreUp = $possessionItemScoreUp->item->max_possession_number - $possessionItemScoreUp->possession_number;
        $pointLimitPointUp = $possessionItemPointUp->item->max_possession_number - $possessionItemPointUp->possession_number;
        $pointLimitHiMP = $possessionItemHiMP->item->max_possession_number - $possessionItemHiMP->possession_number;
        
        $user = Auth::user();
        $userPoint = $user->point;
        
        return view('items.create', compact('possessionItems', 'pointLimitHP', 'pointLimitMP', 'pointLimitScoreUp', 'pointLimitPointUp', 'pointLimitHiMP', 'user', 'userPoint'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request)
    {
        $possessionItem = PossessionItem::where('user_id', Auth::id())->where('item_id', $request->input('clearing'))->first();
        $possessionItem->possession_number += $request->input('count');
        $possessionItem->save();
        
        $user = Auth::user();
        $user->point -= $request->input('usePoint');
        $user->save();
        
        return redirect()->route('items.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
