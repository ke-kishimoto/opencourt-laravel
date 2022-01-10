<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function newAccount()
    {
        return view('newAccount', ['title' => '新規登録']);
    }

    public function regist()
    {
        return view('userRegist', ['title' => 'メンバー登録']);
    }

    public function management()
    {
        return view('userList', ['title' => 'メンバー管理']);
    }

    public function getUserList(Request $request)
    {
        $data = User::where('name', 'like', "%{$request->name}%")->get();
        return response($data, 200);
    }

    public function show($id)
    {
        return view('userDetail', 
            [
                'title' => 'メンバー詳細',
                'id' => $id,
            ]
        );
    }

    public function get($id)
    {
        return response(User::find($id), 200);
    }

    public function create(Request $request)
    {
        if($request->password !== $request->rePassword) {
            return view('userRegist', ['title' => 'メンバー登録']);
        }
        User::create([
            'role_level' => $request->role_level,
            'user_category_id' => $request->user_category_id,
            'gender' => $request->gender,
            'name' => $request->name,
            'status' => 1,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remark' => $request->remark,
        ]);
        return view('userManagement', ['title' => 'メンバー管理']);

    }

    public function updateBlacklist($id)
    {
        $user = User::find($id);
        if($user->status === 1) {
            $user->status = 2;
        } else if ($user->status === 2) {
            $user->status = 1;
        }
        $user->save();
        return response($user, 200);
    }

    public function updateAuthority($id)
    {
        $user = User::find($id);
        if($user->role_level === 2) {
            $user->role_level = 3;
        } else if ($user->role_level === 3) {
            $user->role_level = 2;
        }
        $user->save();
        return response($user, 200);
    }
}
