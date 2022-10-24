<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConfirmController extends Controller
{
    public function createAccountCommercial(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->active = 1;
        $user->save();
        Auth::login($user);
        dd($user);
        return redirect('/forum');
    }



}
