<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;

class LoginLogoutController extends Controller
{
  public function login(Request $request) {
    Log::debug($request);
    if(strpos($request->email, '@')) {
        $rule = ['required', 'email'];
        $column = 'email';
    } else {
        $rule = 'required';
        $column = 'user_name';
    }
    $credentials = $request->validate([
        'email' => $rule,
        'password' => ['required'],
    ]);

    if ($column === 'email' && Auth::attempt($credentials) || $column === 'login_id') {
        $user = User::where($column, $request->email)->first();
        if($user) {
            $token = $user->createToken('my-app-token');

            return response([
                'user' => $user,
                'token' => $token->plainTextToken
            ], 200);
        }
    }

    return response([
        'MESSAGE' => '認証エラー',
    ], 400);
  }
}
