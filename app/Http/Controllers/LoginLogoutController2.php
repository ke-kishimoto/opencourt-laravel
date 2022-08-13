<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginLogoutService;
use Illuminate\Support\Facades\Log;

class LoginLogoutController2 extends Controller
{

    protected $loginLogoutService;

    public function __construct(LoginLogoutService $loginLogoutService)
    {
        $this->loginLogoutService = $loginLogoutService;
    }

    public function login(Request $request)
    {
        Log::debug('user', [$request->user()]);
        return view('login', ['title' => 'ログイン']);
    }

    public function loginCheck(Request $request)
    {
        $user = $this->loginLogoutService->loginCheck($request);
        if($user) {
            $token = $user->createToken('login');
            $request->session()->put('user', $user);
            // return view('index', ['title' => 'カレンダー']);
            // return redirect()->route('index');
            // return redirect('/index');
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
            return response($data, 200);

        } else {
            // return view('login', ['title' => 'ログイン']);
            $data = [];
            return response($data, 400);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return view('index', ['title' => 'カレンダー']);
    }
}
