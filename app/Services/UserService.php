<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberService
{
    public function createUser($request)
    {
        $user = new User(
            [
                "role_level" => 3,  // 一般
                "email" => $request->email,
                "name" => $request->name,
                "password" => Hash::make($request->password),
                "category_id" => $request->category_id,
                "gender" => $request->gender,
                "remark" => $request->remark
            ]
        );
        
        $result = MailService::createNewUser($user);
        if($result) {
            return $user->save();
        } else {
            throw new \Exception("登録に失敗しました。");
        }
    }

    public function updateUser($request)
    {
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->category_id = $request->category_id;
        $user->gender = $request->gender;
        $user->remark = $request->remark;
        return $user->save();
    }

    public function passwordReset($request)
    {
        $user = User::find($request->id);
        // 8文字で適当なパスワードを生成
        $password = substr(base_convert(md5(uniqid()), 16, 36), 0, 8);
        $user->password = Hash::make($password);
        $user->save();
        $result = MailService::passwordReset($user, $password);
        if($result) {
            return $user->save();
        } else {
            throw new \Exception("パスワードのリセットに失敗しました。");
        }
    }
}
