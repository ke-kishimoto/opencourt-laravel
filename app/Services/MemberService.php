<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class MemberService
{
    public function createMember($request)
    {
        $member = new Member(
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
        
        // $result = MailService::createNewMember($member);
        // if($result) {
        //     return $member->save();
        // } else {
        //     throw new \Exception("登録に失敗しました。");
        // }
    }

    public function updateMember($request)
    {
        $member = Member::find($request->id);
        $member->email = $request->email;
        $member->name = $request->name;
        $member->category_id = $request->category_id;
        $member->gender = $request->gender;
        $member->remark = $request->remark;
        return $member->save();
    }

    public function passwordReset($request)
    {
        $member = Member::find($request->id);
        // 8文字で適当なパスワードを生成
        $password = substr(base_convert(md5(uniqid()), 16, 36), 0, 8);
        $member->password = Hash::make($password);
        $member->save();
        $result = MailService::passwordReset($member, $password);
        if($result) {
            return $member->save();
        } else {
            throw new \Exception("パスワードのリセットに失敗しました。");
        }
    }
}
