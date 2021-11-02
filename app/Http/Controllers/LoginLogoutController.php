<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginLogoutController extends Controller
{
    public function login()
    {
        return view('login', ['title' => 'ログイン']);
    }
}
