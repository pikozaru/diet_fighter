<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    public function index()
    {
        // ユーザー情報取得
        $user = Auth::user();
        $carbonNow = Carbon::now();
        
        return view('userInformations.index', compact('user', 'carbonNow'));
    }
}
