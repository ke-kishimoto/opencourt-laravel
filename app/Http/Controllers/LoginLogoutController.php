<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\LineLoginService;


class LoginLogoutController extends Controller
{
    private $lineLoginService;

    public function __construct(LineLoginService $lineLogin)
    {
        $this->lineLoginService = $lineLogin;
    }

    public function login(Request $request) {
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

    public function lineLogin($code)
    {
        // アクセストークン取得
        $response = $this->lineLoginService->getAccessToken($code);
        $accessToken = $response->access_token;
        $refreshToken = $response->refresh_token;
        $idToken = $response->id_token;

        // IDの検証
        $result = $this->lineLoginService->tokenVerify($idToken);

        // ユーザー取得
        $user = $this->lineLoginService->createOrUpdateUser($result, $accessToken, $refreshToken);

        $token = $user->createToken('my-app-token');

        return response([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        // トークンの削除
        $request->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();
    }

    public function changePassword(Request $request)
    {
        if(Hash::check($request->password, $request->user()->password)) {
          if($request->newPassword === $request->rePassword) {
            $user = User::find($request->user()->id);
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response([], 200);
          } else {
            return response(['msg' => '入力したパスワードが異なります'], 400);
          }
        } else {
          return response(['msg' => '現在のパスワードが異なります'], 400);
        }
    }
}
