<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\LineMessagingService;
use App\Models\EventUser;

class LineController extends Controller
{

  private $lineMessagingService;
    public function __construct(LineMessagingService $lineMessaging)
    {
        $this->lineMessagingService = $lineMessaging;
    }

   // webhook
   public function webhook(Request $request)
   {

      // webhookリクエストを受け取る
      $json = file_get_contents("php://input");
      $contents = json_decode($json, true);
      $events = $contents['events'];

       // 署名の検証
       // $httpHeaders = getallheaders();
       // $lineSignature = $httpHeaders["X-Line-Signature"];
       // 上でも取得できるが、大文字小文字を区別しないためには下記で取得が無難
       $lineSignature = $_SERVER['HTTP_X_LINE_SIGNATURE'];
       $channelSecret = env('LINE_MESSAGING_API_CHANNEL_SECRET'); // Channel secret string
       $hash = hash_hmac('sha256', $json, $channelSecret, true);
       $signature = base64_encode($hash);
       // Compare x-line-signature request header string and the signature
       if($signature !== $lineSignature) {
           return;
       }

       foreach($events as $event) {
           if ($event['mode'] !== 'active') {
               continue;
           }
           
           // 友達追加された場合
           if(isset($event['type']) && $event['type'] === 'follow') {
            $this->lineMessagingService->addFriend($event);
           }

           // 友達解除された場合
           if(isset($event['type']) && $event['type'] === 'unfollow') {
            $this->lineMessagingService->unfollow($event);
           }
           
           // メッセージが送信された場合
           if(isset($event['message']) && $event['message']['type'] === 'text') {
            $this->lineMessagingService->receiveMessageText($event, env('LINE_MESSAGING_API_CHANNEL_ACCESS_TOKEN'));
           }

           // 返信があった場合
           if(isset($event['postback'])) {
            $this->lineMessagingService->receivePostback($event, env('LINE_MESSAGING_API_CHANNEL_ACCESS_TOKEN'));
        }
           
       }

      return response([], 200);
   }

   public function sendMessage(Request $request)
   {
      $targetUsers = EventUser::where('event_id', $request->event_id)
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('users')
              ->whereColumn('users.id', 'event_users.user_id')
              ->whereNotNull('line_id');
      })
      ->get();
      foreach($targetUsers as $targetUser) {

      }
   }
}
