<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function newAccount()
    {
        return view('newAccount', ['title' => '新規登録']);
    }

    public function management()
    {
        return view('memberManagement', ['title' => 'メンバー管理']);
    }

    public function getMemberList(Request $request)
    {
        $data = Member::where('name', 'like', "%{$request->name}%")->get();
        return response($data, 200);
    }

    public function show($id)
    {
        return view('memberDetail', 
            [
                'title' => 'メンバー詳細',
                // 'member' => Member::with('memberCategory')->find($id),
                'id' => $id,
            ]
        );
    }

    public function get($id)
    {
        return response(Member::find($id), 200);
    }

    public function updateBlacklist($id)
    {
        $member = Member::find($id);
        if($member->status === 1) {
            $member->status = 2;
        } else if ($member->status === 2) {
            $member->status = 1;
        }
        $member->save();
        return response($member, 200);
    }

    public function updateAuthority($id)
    {
        $member = Member::find($id);
        if($member->role_level === 2) {
            $member->role_level = 3;
        } else if ($member->role_level === 3) {
            $member->role_level = 2;
        }
        $member->save();
        return response($member, 200);
    }
}
