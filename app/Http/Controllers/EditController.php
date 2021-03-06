<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nameEdit()
    {
        // 名前の変更
        $user = Auth::user();
        
        return view('edits.name', compact('user'));
    }


    public function nameUpdate(Request $request)
    {
        // 名前の変更を適用
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();
        
        return redirect()->route('userInformations.index');
    }
    
    
    public function emailEdit()
    {
        // メールアドレスの変更
        $user = Auth::user();
        
        return view('edits.email', compact('user'));
    }
    
    
    public function emailUpdate(Request $request)
    {
        // メールアドレスの変更の適用
        $user = Auth::user();
        $user->email = $request->input('email');
        $user->save();
        
        return redirect()->route('userInformations.index');
    }
    
    
    public function heightEdit()
    {
        // 身長の変更
        $user = Auth::user();
        
        return view('edits.height', compact('user'));
    }
    
    
    public function heightUpdate(Request $request)
    {
        // 身長の変更の適用
        $user = Auth::user();
        $user->height = $request->input('height');
        $user->save();
        
        return redirect()->route('userInformations.index');
    }
}
