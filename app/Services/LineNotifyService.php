<?php

namespace App\Services;

use App\Models\Event;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Log;

class LineNotifyService
{
    const LINE_API_URL = 'https://notify-api.line.me/api/notify';

    public function reserve($eventId, $user, $eventUser, $companionCount)
    {
      $event = Event::find($eventId);
      $category = UserCategory::find($user->user_category_id);
      $msg = view('line.notify.reserve', 
        [
          'category' => $category->category_name,
          'user' => $user, 
          'eventUser' => $eventUser,
          'event' => $event,
          'companion' => $companionCount,
        ])->render();
      $this->lineNotify($msg);
    }

    public function cancel($eventId, $user)
    {
      $event = Event::find($eventId);
      $msg = view('line.notify.cancel', ['user' => $user, 'event' => $event,])
      ->render();
      $this->lineNotify($msg);
    }

    // LINE通知用のfunction
    private function lineNotify($message) 
    {
        if(!env('LINE_NOTIFY_TOKEN', '')) {
          Log::debug('LINE通知：環境変数エラー');
          return false;
        }
        // 連想配列作ってるだけ
        $data = array(
            "message" => $message
        );
        // URL エンコードされたクエリ文字列を生成する
        $data = http_build_query($data, "", "&");

        try {
            $options = array(
                'http'=>array(
                'method'=>'POST',
                'header'=>"Authorization: Bearer " . env('LINE_NOTIFY_TOKEN') . "\r\n"
                . "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: ".strlen($data)  . "\r\n" ,
                'content' => $data
                )
            );
            $context = stream_context_create($options);
            $resultJson = file_get_contents(self::LINE_API_URL ,FALSE,$context );
            $resutlArray = json_decode($resultJson,TRUE);
            if( $resutlArray['status'] != 200)  {
                Log::debug('LINE通知：ステータスエラー');
                return false;
            }
            Log::debug('LINE通知：通知完了');
            return true;
        } catch(\Exception $ex) {
            Log::debug('LINE通知：エラー');
            Log::debug($ex);
            return false;
        }
    }
}
