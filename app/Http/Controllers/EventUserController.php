<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EventUser;

class EventUserController extends Controller
{
    public function create(Request $request)
    {
      $result =EventUser::create([
        'event_id' => $request->event_id,
        'user_id' => $request->user_id,
        'remark' => $request->remark,
        'status' => '1',
        'attendance' => '1',
      ]);

      // TODO
      // 同伴者の登録

      return response($result, 200);

    }
}