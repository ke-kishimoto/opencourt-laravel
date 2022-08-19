<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class LineLoginService
{

    public function getAccessToken($code) 
    {
      
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded'
        );
        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => env('LINE_LOGIN_COLLBACK_URL'),
            'client_id' => env('LINE_LOGIN_CLIENT_ID'),
            'client_secret' => env('LINE_LOGIN_CLIENT_SECRET')
        );

        $url = 'https://api.line.me/oauth2/v2.1/token';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, TRUE);                          //POSTで送信
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);                //受け取ったデータを変数に
        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }


    public function accessTokenVerify($accessToken)
    {
        $url = 'https://api.line.me/oauth2/v2.1/verify';
        $ch = curl_init($url);
        $data = array(
            'access_token' => $accessToken,
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);  // ステータスコードを受け取る
        curl_close($ch);

        return $result;
    }

    public function updateToken($refreshToken)
    {
        $url = 'https://api.line.me/oauth2/v2.1/token';
        $ch = curl_init($url);
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded'
        );
        $data = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => env('LINE_LOGIN_CLIENT_ID'),
            'client_secret' => env('LINE_LOGIN_CLIENT_SECRET'),
        );
        curl_setopt($ch, CURLOPT_POST, TRUE);                          //POSTで送信
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }

    public function tokenVerify($idToken)
    {
        $url = 'https://api.line.me/oauth2/v2.1/verify';
        $ch = curl_init($url);
        $data = array(
            'id_token' => $idToken,
            'client_id' => env('LINE_LOGIN_CLIENT_ID'),
        );
        curl_setopt($ch, CURLOPT_POST, TRUE);                          //POSTで送信
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result);
    }
    
    /**
     * @Route("/getLineProfile")
     */
    public function getLineProfile($accessToken)
    {
        $url = 'https://api.line.me/v2/profile';
        $headers = array(
            "Authorization: Bearer {$accessToken}"
        );
        // var_dump($headers);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
        $result = curl_exec($ch);
        return json_decode($result);
    }

    public function getLineProfileByCode($code) 
    {

        // アクセストークンの取得
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded'
        );
        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => env('LINE_LOGIN_COLLBACK_URL'),
            'client_id' => env('LINE_LOGIN_CLIENT_ID'),
            'client_secret' => env('LINE_LOGIN_CLIENT_SECRET')
        );

        $url = 'https://api.line.me/oauth2/v2.1/token';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, TRUE);                          //POSTで送信
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);                //受け取ったデータを変数に
        $result = curl_exec($ch);

        curl_close($ch);
        $response = json_decode($result);

        $accessToken = $response->access_token;
        $idToken = $response->id_token;

        // id tokenの検証
        $response = $this->tokenVerify($idToken);

        // プロフィールの取得
        $url = 'https://api.line.me/v2/profile';
        $headers = array(
            "Authorization: Bearer {$accessToken}"
        );
        // var_dump($headers);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
        $result = curl_exec($ch);
        return json_decode($result);

    }

    public function createOrUpdateUser($result, $accessToken, $refreshToken)
    {
        $user = User::where('line_id', $result->sub)->first();
        if($user) {
            return $user;
        } else {
            $user = new User();
            $user->name = $result->name;
            $user->role_level = 'system_admin';
            $user->status = 'active';
            $user->line_id = $result->sub;
            $user->line_access_token = $accessToken;
            $user->line_refresh_token = $refreshToken;
            $user->description = '';
            $user->save();
        }
        return $user;
    }
}
