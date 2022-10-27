<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_jwt', ['only' => ['autologin']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {

            return response()->json([
                'status' => 'error',
                'error' => 'Invalid username, password, security token',
                'msg' => 'Invalid username, password, security token'
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        auth()->login($user);
        // return redirect()->intended('/forum');
        $response  = [
            'msg' => 'You are logged in!',
            'token' => $token,
            'user_name' => $user->name,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function autologin(Request $request){
        $user = auth()->user();   
        Auth::loginUsingId($user->id, true);

        return redirect()->intended('/forum');
    }
}
