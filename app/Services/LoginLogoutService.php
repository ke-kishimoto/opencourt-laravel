<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginLogoutService
{
    public function loginCheck($request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            // emailが不正
            // return [];
        }
        $pass = Hash::make($request->password);
        if($user !== $pass) {
            // パスワードが不正
            // return [];
        }
        return $user;
    }
}
