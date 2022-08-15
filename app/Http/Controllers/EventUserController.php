<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EventUser;
use App\Models\EventUserCompanion;

// TODO-トランザクション追加

class EventUserController extends Controller
{

    public function getEventUser($id)
    {
        $users = EventUser::with('user')
        ->with('user.userCategory')
        ->with('companions')
        ->with('companions.userCategory')
        ->where('event_id', $id)
        ->orderBy('created_at')->get();

        return response($users, 200);
    }

    public function getEventListByUser($userId)
    {
        $events = EventUser::with('event')
        ->where('user_id', $userId)
        ->orderBy('created_at')->get();

        return response($events, 200);
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

    public function delete(Request $request, $eventId)
    {
      $eventUser = EventUser::where('event_id', $eventId)
      ->where('user_id', $request->user()->id)
      ->first();

      // 同伴者削除
      EventUserCompanion::where('event_user_id', $eventUser->id)->delete();

      $eventUser->delete();

      return response([], 200);

    }
}