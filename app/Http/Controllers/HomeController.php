<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PossessionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $possessionItems = PossessionItem::where('user_id', Auth::id())->count();
        
        if($possessionItems != 0) {
            return redirect()->route('mains.index');
        } else {
            return view('home');
        }
    }
    
    public function store(Request $request)
    {
        $items = Item::all();
        
        foreach($items as $item) {
            $addPossessionItemDataBase = new PossessionItem();
            $addPossessionItemDataBase->user_id = Auth::id();
            $addPossessionItemDataBase->item_id = $item->id;
            $addPossessionItemDataBase->save();
        }
        
        return redirect()->route('mains.index');
    }
}
