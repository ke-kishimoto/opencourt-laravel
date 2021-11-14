<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

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
        $data = Member::get();
        return response($data, 200);
    }

    public function show($id)
    {
        return view('memberDetail', 
            [
                'title' => 'メンバー詳細',
                'member' => Member::with('memberCategory')->find($id),
            ]
        );
    }
}
