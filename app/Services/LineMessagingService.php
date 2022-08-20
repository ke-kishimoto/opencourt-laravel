<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Event;
use App\Models\UserCategory;

class LineMessagingService
{

  const CAROUSEL_NUM = 10; // カルーセルは最大10件らしい

  // 友達追加された時の処理
  public function addFriend($event, $channelAccessToken)
  {
    $user = User::where('line_id', ($event['source']['userId']))->first();
    if (!$user) {
      // ユーザーが存在しない場合は登録する
      $user = new User();
      $user->role_level = 'general';
      $user->line_id = $event['source']['userId'];

      // プロフィール取得
      $url = "https://api.line.me/v2/bot/profile/{$event['source']['userId']}"; // リプライ
      $ch = curl_init($url);
      $headers = array(
        "Authorization: Bearer {$channelAccessToken}"
      );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
      $result = json_decode(curl_exec($ch));
      $user->name = isset($result->displayName) ? $result->displayName : '';
      $user->save();
    }
  }

  // ブロックされた時の処理（友達解除された時）
  public function unfollow($event)
  {
    Log::debug('ユーザー削除');
    $user = User::where('line_id', ($event['source']['userId']))->first();
    if ($user) {
      // ユーザーを削除する
      $user->delete();
    }
  }

  // メッセージを受信した時
  public function receiveMessageText($event, $channelAccessToken)
  {
    $text = $event['message']['text'];
    $url = 'https://api.line.me/v2/bot/message/reply'; // リプライ
    $ch = curl_init($url);
    $headers = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$channelAccessToken}"
    );
    // dataの取得
    if ($text === '予約' || $text === 'キャンセル' || $text === '予約確認') {
      $data = $this->eventSelect($event, $text);
    } elseif ($text === '職種') {
      $data = $this->categorySelect($event);
    } elseif ($text === '性別') {
      $data = $this->genderSelect($event);
    } elseif ($text === 'プロフィール確認') {
      $data = $this->profileConfirmation($event);
    } else {
      $data = $this->atherMessage($event);
    }
    // リクエストの送信
    curl_setopt($ch, CURLOPT_POST, TRUE);  //POSTで送信
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($data)); //データをセット
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
    $result = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // ステータスコードを受け取る
    curl_close($ch);
  }

  // イベント選択時 カルーセルVer
  private function eventSelect($event, $text)
  {
    $user = User::where('line_id', ($event['source']['userId']))->first();
    if ($text === '予約') {
      // $eventList = $gameInfoDao->getGameInfoListByAfterDate(date('Y-m-d'), '', $event['source']['userId']);

      $eventList = Event::where('event_date', '>=', date('Y-m-d'))
        ->whereNotExists(function ($query) use ($user) {
          $query->select(DB::raw(1))
            ->from('event_users')
            ->whereColumn('event_users.event_id', 'events.id')
            ->where('event_users.user_id', $user->id);
        })->get();
      if (!$eventList) {
        return json_encode([
          'replyToken' => "{$event['replyToken']}",
          'messages' => [
            [
              'type' => 'text',
              'text' => '開催予定のイベントはありません。',
            ]
          ]
        ]);
      }
      $mode = 'reserve';
    } elseif ($text === 'キャンセル' || $text === '予約確認') {
      // $eventList = $detailDao->getEventListByLineId($event['source']['userId'], date('Y-m-d'));
      $eventList = Event::where('event_date', '>=', date('Y-m-d'))
        ->whereExists(function ($query) use ($user) {
          $query->select(DB::raw(1))
            ->from('event_users')
            ->whereColumn('event_users.event_id', 'events.id')
            ->where('event_users.user_id', $user->id);
        })->get();
      if (!$eventList) {
        return json_encode([
          'replyToken' => "{$event['replyToken']}",
          'messages' => [
            [
              'type' => 'text',
              'text' => '予約されたイベントはありません。',
            ]
          ]
        ]);
      }
      if ($text === 'キャンセル') {
        $mode = 'cancel';
      } elseif ($text === '予約確認') {
        $mode = 'confirm';
      }
    }
    $columns = [];
    foreach ($eventList as $eventInfo) {

      // カルーセルVer
      $columns[] = [
        "text" => $this->getEventInfoShort($eventInfo),
        "actions" => [
          [
            'type' => 'postback',
            'label' => "詳細確認",
            'data' => "action=select&mode={$mode}&id={$eventInfo['id']}",
            'displayText' => "詳細確認"
          ]
        ],
      ];
      if (count($columns) >= self::CAROUSEL_NUM) {
        break;
      }
    }

    // 応答メッセージを返す // カルーセルVer
    return json_encode([
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'template',
          "altText" => "this is a carousel template",
          'template' => [
            "type" => "carousel",
            "columns" => $columns
          ]
        ]
      ]
    ]);
  }

  // postbackを受信した時
  public function receivePostback($event, $channelAccessToken)
  {
      $data = explode('&', $event['postback']['data']);
      // 文字列から連想配列を作成
      foreach($data as $item) {
          $keyValue = explode('=', $item);
          $data[$keyValue[0]] = $keyValue[1];    
      }
      if(isset($data['action']) && $data['action'] === 'profile') {
          $this->profileRegist($event, $channelAccessToken, $data);
      // } elseif(isset($data['action']) && $data['action'] === 'select') {
      //     $this->eventDetail($event, $channelAccessToken, $data);
      // } elseif(isset($data['action']) && ($data['action'] === 'reserve' || $data['action'] === 'cancel')) {
      //     $this->eventReserveOrCancel($event, $channelAccessToken, $data);
      }
  }

  // カテゴリ選択 ボタンテンプレートVer
  private function categorySelect($event)
  {
    $categories = UserCategory::where('category_name', '<>', "''")
                  ->orderBy('id')
                  ->get();
    $choices = [];
    foreach($categories as $category) {
      $choices[] = [
        'type' => 'postback',
        'label' => $category->category_name,
        'data' => "action=profile&type=category&id={$category->id}",
        'displayText' => $category->category_name
      ];
    }
    $choices[] = [
      'type' => 'postback',
      'label' => '設定しない',
      'data' => "action=profile&type=category&id=0",
      'displayText' => '設定しない'
    ];

    return json_encode([
      'replyToken' => "{$event['replyToken']}",
      'messages' =>
      [
        [
          "type" => "template",
          "altText" => "カテゴリ選択",
          "template" =>
          [
            "type" => "buttons",
            "text" => "カテゴリを選択してください。（高校生以下の場合は高校生を選択してください）",
            "actions" => $choices
          ]
        ]
      ]
    ]);
  }

  // 性別の選択　ボタンテンプレートVer
  private function genderSelect($event)
  {
    return json_encode([
      'replyToken' => "{$event['replyToken']}",
      'messages' =>
      [
        [
          "type" => "template",
          "altText" => "性別設定",
          "template" =>
          [
            "type" => "buttons",
            "text" => "性別を選択してください。",
            "actions" =>
            [
              [
                'type' => 'postback',
                'label' => '男性',
                'data' => "action=profile&type=gender&id=men",
                'displayText' => '男性'
              ],
              [
                'type' => 'postback',
                'label' => '女性',
                'data' => "action=profile&type=gender&id=women",
                'displayText' => '女性'
              ],
              [
                'type' => 'postback',
                'label' => '設定しない',
                'data' => "action=profile&type=gender&id=0",
                'displayText' => '設定しない'
              ],
            ]
          ]
        ]
      ]
    ]);
  }

  private function profileConfirmation($event)
  {
    $user = User::where('line_id', $event['source']['userId'])->first();
    $category = UserCategory::find($user->user_category_id);
    $text = view('line.message.profile', 
        [
          'user'=> $user, 
          'category' => !empty($category) ? $category->category_name : ''
        ])
        ->render();

    return json_encode([
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'text',
          'text' => $text,
        ]
      ]
    ]);
  }

  public function atherMessage($event)
  {
    return json_encode([
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'text',
          'text' => '恐れ入りますが送信されたメッセージには対応しておりません。',
        ]
      ]
    ]);
  }

  private function profileRegist($event, $channelAccessToken, $data)
    {
        if($data['id'] == 0) {
            return;
        }

        $user = User::where('line_id', $event['source']['userId'])->first();
        if($data['type'] === 'category' && $data['id'] != 0) {
            $user->user_category_id = $data['id'];
        }
        if($data['type'] === 'gender' && $data['id'] != 0) {
            $user->gender = $data['id'];
        }
        $user->save();
        $text = '登録完了しました。';

        // 完了メッセージ送信
        $url = 'https://api.line.me/v2/bot/message/reply'; // リプライ
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer {$channelAccessToken}"
        );
        $data = json_encode([
            'replyToken' => "{$event['replyToken']}",
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $text,                            
                ]
            ]
        ]);
        curl_setopt($ch, CURLOPT_POST, TRUE);  //POSTで送信
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data)); //データをセット
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に

        curl_exec($ch);
        curl_close($ch);
    }


  private function getEventInfoShort($event)
  {
    return "イベント詳細\n イベント：{$event->title}\n 日付：{$event->event_date}\n 開始時刻：{$event->start_time}\n 場所：{$event->place}";
  }
}
