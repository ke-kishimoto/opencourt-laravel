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
          'name1' => ['required'],
          'email' => ['required', 'email', 'unique:users'],
          'category1' => ['required'],
          'gender1' => ['required'],
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

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->gender = $request->gender1;
        $user->user_category_id = $request->category1;
        $user->description = $request->description;

        $user->save();
        return response($user, 200);

    }

    public function delete($id)
    {
      $user = User::find($id);
      $user->delete();
      return response([], 200);
    }

    public function updateRole(Request $request)
    {
      $user = User::find($request->id);
      $user->role_level = $request->role_level;
      $user->save();
      return response($user, 200);
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response($user, 200);
    }

}
