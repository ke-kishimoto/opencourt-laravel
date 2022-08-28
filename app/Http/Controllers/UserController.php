<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserList(Request $request)
    {
        $keyword = $request->name ?? '';
        $data = User::with('userCategory')->where('name', 'like', "%{$keyword}%")->get();
        return response($data, 200);
    } 

    public function get($id)
    {
        return response(User::with('userCategory')->find($id), 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
          'name' => ['required'],
          'email' => ['required', 'email', 'unique:users'],
          'category1' => ['required'],
          'gender' => ['required'],
          'password' => ['required'],
       ]);
        if($request->password !== $request->rePassword) {
            return response([], 400);
        }
        $roleLevel = 'general';
        $user = User::create([
            'role_level' => $roleLevel,
            'user_category_id' => $request->category1,
            'gender' => $request->gender1,
            'name' => $request->name1,
            'status' => 'active',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'description' => $request->description,
        ]);
        return response($user, 200);
    }

    public function delete($id)
    {
      $user = User::find($id);
      $user->delete();
      return response([], 200);
    }

    // public function updateBlacklist($id)
    // {
    //     $user = User::find($id);
    //     if($user->status === 1) {
    //         $user->status = 2;
    //     } else if ($user->status === 2) {
    //         $user->status = 1;
    //     }
    //     $user->save();
    //     return response($user, 200);
    // }

    // public function updateAuthority($id)
    // {
    //     $user = User::find($id);
    //     if($user->role_level === 2) {
    //         $user->role_level = 3;
    //     } else if ($user->role_level === 3) {
    //         $user->role_level = 2;
    //     }
    //     $user->save();
    //     return response($user, 200);
    // }
}
