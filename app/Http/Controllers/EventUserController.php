<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\EventUser;
use App\Models\EventUserCompanion;
use App\Models\User;
use App\Services\LineNotifyService;
use App\Services\MailService;

class EventUserController extends Controller
{

    private $lineNotifyService;
    private $mailService;

    public function __construct(LineNotifyService $lineNotify, MailService $mailService)
    {
        $this->lineNotifyService = $lineNotify;
        $this->mailService = $mailService;
    }

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

      $eventUser = EventUser::where('event_id', $request->event_id)
      ->where('user_id', $request->user_id)
      ->first();

      if($eventUser) {
        return response('予約が重複しています', 400);
      }

      DB::transaction(function () use ($request) {

        // TODO-イベントの状態によって判断
        $status = 'participation';
        if ($status === 'participation') {
          $attendance = 'attendance';
        } else {
          $attendance = 'absence';
        }
  
        $eventUser = EventUser::create([
          'event_id' => $request->event_id,
          'user_id' => $request->user_id,
          'remark' => $request->remark,
          'status' => $status,
          'attendance' => $attendance,
        ]);
  
        // 同伴者の登録
        $companionCount = 0;
        foreach($request->companions as $companion) {
          EventUserCompanion::create([
            'event_id' => $request->event_id,
            'event_user_id' => $eventUser->id,
            'name' => $companion['name'],
            'user_category_id' => $companion['category'],
            'gender' => $companion['gender'],
            'status' => $status,
            'attendance' => $attendance,
          ]);
          $companionCount++;
        }

        $this->mailService->joinEventUser($request->user());
  
        // LINE通知
        $this->lineNotifyService->reserve(
            $request->event_id, 
            $request->user(),
            $eventUser, 
            $companionCount);
      });


      return response([], 200);
    }

    // 参加のキャンセル
    public function delete(Request $request, $id)
    {
      if($id != 0) {
        $eventUser = EventUser::find($id);
      } else {
        $eventUser = EventUser::where('event_id', $request->event_id)
        ->where('user_id', $request->user_id)
        ->first();
      }

      DB::transaction(function () use ($eventUser) {
        // 同伴者キャンセル
        EventUserCompanion::where('event_user_id', $eventUser->id)->delete();
  
        // ユーザーのキャンセル
        $eventUser->delete();
      });

      $this->mailService->cancelEvent($request->user(), $request->event_id);

      // LINE通知
      $user = User::find($eventUser->user_id);
      $this->lineNotifyService->cancel(
        $eventUser->event_id, 
        $user);

      return response([], 200);

    }

    // 一括予約
    public function bulkResevation(Request $request)
    {
      foreach($request->event_ids as $eventId) {
        // TODO-イベントの状態によって判断
        $status = 'participation';
        if ($status === 'participation') {
          $attendance = 'attendance';
        } else {
          $attendance = 'absence';
        }

        EventUser::create([
          'event_id' => $eventId,
          'user_id' => $request->user_id,
          'status' => $status,
          'attendance' => $attendance,
        ]);
      }

      // LINE通知
      $this->lineNotifyService->bulkReserve(
        $request->user()->name, 
        count($request->event_ids));

      return response([], 200);

    }

    // ステータスの変更
    public function changeStatus(Request $request)
    {
        $eventUser = EventUser::find($request->id);
        if($eventUser->status === 'participation') {
          $eventUser->status = 'cancel_waiting';
        } else {
          $eventUser->status = 'participation';
        }
        $eventUser->save();
    }

    // LINE通知対象者人数取得
    public function getLinePushTargetUserCount($eventId)
    {
        $count = EventUser::where('event_id', $eventId)
        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
                ->from('users')
                ->whereColumn('users.id', 'event_users.user_id')
                ->whereNotNull('line_id');
        })
        ->count();
        return response($count, 200);
    }
}