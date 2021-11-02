<?php

namespace App\Service;

use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class LoginLogoutService
{
    public function login($request)
    {
        $member = Member::where('email', $request->email)->first();
        if(!$member) {
            // emailが不正
        }
        $pass = Hash::make($request->password);
        if($member !== $pass) {
            // パスワードが不正
        }
        return $member;
    }

    public function logout()
    {
        
    }
}
