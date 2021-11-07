<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginLogoutService;
use Illuminate\Support\Facades\Log;

class LoginLogoutController extends Controller
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
        $member = $this->loginLogoutService->loginCheck($request);
        if($member) {
            $token = $member->createToken('login');
            $request->session()->put('user', $member);
            // return view('index', ['title' => 'カレンダー']);
            // return redirect()->route('index');
            // return redirect('/index');
            $data = [
                'user' => $member,
                'token' => $token->plainTextToken,
            ];
            return response($data, 200);

        } else {
            // return view('login', ['title' => 'ログイン']);
            $data = [];
            return response($data, 400);
        }
    }
}
