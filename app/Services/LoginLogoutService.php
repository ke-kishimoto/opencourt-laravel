<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class LoginLogoutService
{
    public function loginCheck($request)
    {
        $member = Member::where('email', $request->email)->first();
        if(!$member) {
            // emailが不正
            // return [];
        }
        $pass = Hash::make($request->password);
        if($member !== $pass) {
            // パスワードが不正
            // return [];
        }
        return $member;
    }
}
