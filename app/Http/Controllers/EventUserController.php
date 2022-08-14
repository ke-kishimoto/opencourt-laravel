<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EventUser;
use App\Models\EventUserCompanion;

class EventUserController extends Controller
{

    public function getEventUser($id)
    {
      $users = EventUser::with('user')->with('user.userCategory')
      ->where('event_id', $id)
      ->orderBy('created_at')->get();

      return response($users, 200);
    }

    public function create(Request $request)
    {
      $eventUser = EventUser::create([
        'event_id' => $request->event_id,
        'user_id' => $request->user_id,
        'remark' => $request->remark,
        'status' => '1',
        'attendance' => '1',
      ]);

      // 同伴者の登録
      foreach($request->companions as $companion) {
        EventUserCompanion::create([
          'event_id' => $request->event_id,
          'event_user_id' => $eventUser->id,
          'name' => $companion['name'],
          'user_category_id' => $companion['category'],
          'gender' => $companion['gender'],
          'status' => '1',
          'attendance' => '1',
        ]);
      }

      return response($eventUser, 200);

    }
}