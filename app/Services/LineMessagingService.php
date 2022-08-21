<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\UserCategory;
use App\Models\EventUser;

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

      // // プロフィール取得
      // $url = "https://api.line.me/v2/bot/profile/{$event['source']['userId']}"; // リプライ
      // $ch = curl_init($url);
      // $headers = array(
      //   "Authorization: Bearer {$channelAccessToken}"
      // );
      // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //受け取ったデータを変数に
      // $result = json_decode(curl_exec($ch));
      $result = Http::withToken($channelAccessToken)
      ->get('https://api.line.me/v2/bot/message/reply');
      $user->name = isset($result['displayName']) ? $result['displayName'] : '';
      $user->save();
    }
  }

  // ブロックされた時の処理（友達解除された時）
  public function unfollow($event)
  {
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
    $response = Http::withToken($channelAccessToken)
      ->post('https://api.line.me/v2/bot/message/reply', $data);
  }

  // イベント選択時 カルーセルVer
  private function eventSelect($event, $text)
  {
    $user = User::where('line_id', ($event['source']['userId']))->first();
    if ($text === '予約') {
      $eventList = Event::where('event_date', '>=', date('Y-m-d'))
        ->whereNotExists(function ($query) use ($user) {
          $query->select(DB::raw(1))
            ->from('event_users')
            ->whereColumn('event_users.event_id', 'events.id')
            ->where('event_users.user_id', $user->id)
            ->whereNull('event_users.deleted_at');
        })->get();
      if (count($eventList) === 0) {
        return [
          'replyToken' => "{$event['replyToken']}",
          'messages' => [
            [
              'type' => 'text',
              'text' => '予約可能なイベントはありません。',
            ]
          ]
        ];
      }
      $mode = 'reserve';
    } elseif ($text === 'キャンセル' || $text === '予約確認') {
      // $eventList = $detailDao->getEventListByLineId($event['source']['userId'], date('Y-m-d'));
      $eventList = Event::where('event_date', '>=', date('Y-m-d'))
        ->whereExists(function ($query) use ($user) {
          $query->select(DB::raw(1))
            ->from('event_users')
            ->whereColumn('event_users.event_id', 'events.id')
            ->where('event_users.user_id', $user->id)
            ->whereNull('event_users.deleted_at');
        })->get();
      if (count($eventList) === 0) {
        return [
          'replyToken' => "{$event['replyToken']}",
          'messages' => [
            [
              'type' => 'text',
              'text' => '予約されたイベントはありません。',
            ]
          ]
        ];
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
    return [
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
    ];
  }

  // postbackを受信した時
  public function receivePostback($event, $channelAccessToken)
  {
    $data = explode('&', $event['postback']['data']);

    if (strpos($data[0], 'richmenu-changed') !== false) {
      return;
    }
    // 文字列から連想配列を作成
    foreach ($data as $item) {
      $keyValue = explode('=', $item);
      $data[$keyValue[0]] = $keyValue[1];
    }
    if (isset($data['action']) && $data['action'] === 'profile') {
      $this->profileRegist($event, $channelAccessToken, $data);
    } elseif (isset($data['action']) && $data['action'] === 'select') {
      $this->eventDetail($event, $channelAccessToken, $data);
    } elseif (isset($data['action']) && ($data['action'] === 'reserve' || $data['action'] === 'cancel')) {
      $this->eventReserveOrCancel($event, $channelAccessToken, $data);
    }
  }

  // カテゴリ選択 ボタンテンプレートVer
  private function categorySelect($event)
  {
    $categories = UserCategory::where('category_name', '<>', "''")
      ->orderBy('id')
      ->get();
    $choices = [];
    foreach ($categories as $category) {
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

    return [
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
    ];
  }

  // 性別の選択　ボタンテンプレートVer
  private function genderSelect($event)
  {
    return [
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
    ];
  }

  private function profileConfirmation($event)
  {
    $user = User::where('line_id', $event['source']['userId'])->first();
    $category = UserCategory::find($user->user_category_id);
    $text = view(
      'line.message.profile',
      [
        'user' => $user,
        'category' => !empty($category) ? $category->category_name : ''
      ]
    )
      ->render();

    return [
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'text',
          'text' => $text,
        ]
      ]
    ];
  }

  public function atherMessage($event)
  {
    return [
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'text',
          'text' => '恐れ入りますが送信されたメッセージには対応しておりません。',
        ]
      ]
    ];
  }

  private function profileRegist($event, $channelAccessToken, $data)
  {
    if ($data['id'] == 0) {
      return;
    }

    $user = User::where('line_id', $event['source']['userId'])->first();
    if ($data['type'] === 'category' && $data['id'] != 0) {
      $user->user_category_id = $data['id'];
    }
    if ($data['type'] === 'gender' && $data['id'] != 0) {
      $user->gender = $data['id'];
    }
    $user->save();
    $text = '登録完了しました。';

    // // 完了メッセージ送信
    $response = Http::withToken($channelAccessToken)
      ->post('https://api.line.me/v2/bot/message/reply', [
        'replyToken' => "{$event['replyToken']}",
        'messages' => [
          [
            'type' => 'text',
            'text' => $text,
          ]
        ]
      ]);
  }

  private function eventDetail($event, $channelAccessToken, $data)
  {
    // イベントの詳細情報を表示する
    $eventInfo = Event::find($data['id']);
    $joinCount = EventUser::where('event_id', $eventInfo->id)->count();
    $categories = UserCategory::where('category_name', '<>', "''")
      ->orderBy('id')
      ->get();
    $info = view(
      'line.message.eventInfo',
      [
        'event' => $eventInfo,
        'category_name1' => isset($categories[0]) ? $categories[0]->category_name : '',
        'category_name2' => isset($categories[1]) ? $categories[1]->category_name : '',
        'category_name3' => isset($categories[2]) ? $categories[2]->category_name : '',
      ]
    )
      ->render();

    if ($data['mode'] === 'reserve') {
      if ($eventInfo->limit_number <= $joinCount) {
        $text = "予約しますか？（キャンセル待ち）";
      } else {
        $text = "予約しますか？";
      }
    } elseif ($data['mode'] === 'cancel') {
      $text = "キャンセルしますか？";
    }

    $body = [
      'replyToken' => "{$event['replyToken']}",
      'messages' =>
      [
        [
          'type' => 'text',
          'text' => $info,
        ]
      ]
    ];

    if ($data['mode'] === 'reserve') {
      $body['messages'][] = [
        "type" => "template",
        "altText" => "予約確認",
        "template" =>
        [
          "type" => "buttons",
          "text" => "{$text}",
          "actions" =>
          [
            [
              'type' => 'postback',
              'label' => '予約する',
              'data' => "action={$data['mode']}&id={$eventInfo->id}&douhan=no",
              'displayText' => '予約する'
            ],
            [
              'type' => 'postback',
              'label' => '同伴者を追加して予約する',
              'data' => "action={$data['mode']}&id={$eventInfo->id}&douhan=yes",
              'displayText' => '同伴者を追加して予約する'
            ],
            [
              'type' => 'postback',
              'label' => '予約しない',
              'data' => "action=no&id={$eventInfo->id}",
              'displayText' => '予約しない'
            ],
          ]
        ]
      ];
    } elseif ($data['mode'] === 'cancel') {
      $body['messages'][] = [
        'type' => 'template',
        'altText' => 'キャンセル確認',
        'template' => [
          "type" => "confirm",
          "text" => $text,
          "actions" => [
            [
              'type' => 'postback',
              'label' => 'する',
              'data' => "action={$data['mode']}&id={$eventInfo->id}",
              'displayText' => 'する'
            ],
            [
              'type' => 'postback',
              'label' => 'しない',
              'data' => "action=no&id={$eventInfo->id}",
              'displayText' => 'しない'
            ]
          ],
        ]
      ];
    }

    $response = Http::withToken($channelAccessToken)
      ->post('https://api.line.me/v2/bot/message/reply', $body);
  }

  private function eventReserveOrCancel($event, $channelAccessToken, $data)
  {
    $eventInfo = Event::find($data['id']);
    $user = User::where('line_id', $event['source']['userId'])->first();

    if (empty($user->user_category_id) || empty($user->gender)) {
      $text = 'プロフィールに未設定の項目があるため更新できません。プロフィール設定から設定を行ってください。';
    } else {
      if ($data['action'] === 'reserve') {

        // 同伴選択の場合
        if ($data['douhan'] === 'yes' && !isset($data['num'])) {
          $this->addDouhan($event, $channelAccessToken, $data['id']);
          return;
        }
        // コントローラーを呼び出して予約を行う
        $companion = [];
        if ($data['douhan'] === 'yes' && isset($data['num'])) {
          $num = (int)$data['num'];
          $companion = [];
          for ($i = 1; $i <= $num; $i++) {
            $companion[] =
              [
                'category' => $user->user_category_id,
                'gender' => $user->gender,
                'name' => "同伴{$i}({$user->name})"
              ];
          }
        }
        $request = Request::create("/", "POST", [
          'event_id' => $eventInfo->id,
          'user_id' => $user->id,
          'remark' => '',
          'companions' => $companion,
        ]);
        $request->setUserResolver(function () use ($user) {
          return $user;
        });

        $controller = app()->make('App\Http\Controllers\EventUserController');
        $response = $controller->create($request);

        if($response->status() === 200) {
            $text = view(
              'line.message.reserve',
              [
                'event' => $eventInfo,
              ]
            )->render();
        } else {
          $text = $response->content();
        }

      } elseif ($data['action'] === 'cancel') {
        // キャンセル
        $request = Request::create("/", "DELETE", []);
        $request->setUserResolver(function () use ($user) {
          return $user;
        });

        $controller = app()->make('App\Http\Controllers\EventUserController');
        $response = $controller->delete($request, $eventInfo->id);
        $text = view('line.message.cancel', ['event' => $eventInfo])->render();

      }
    }
    // 完了メッセージ送信
    $data = [
      'replyToken' => "{$event['replyToken']}",
      'messages' => [
        [
          'type' => 'text',
          'text' => $text,
        ]
      ]
    ];

    Http::withToken($channelAccessToken)
      ->post('https://api.line.me/v2/bot/message/reply', $data);
  }

  private function addDouhan($event, $channelAccessToken, $id)
  {

    $body = [
      'replyToken' => "{$event['replyToken']}",
      'messages' =>
      [
        [
          "type" => "template",
          "altText" => "同伴者選択",
          "template" =>
          [
            "type" => "buttons",
            "text" => "同伴者の人数を選択してください。",
            "actions" =>
            [
              [
                'type' => 'postback',
                'label' => '1人',
                'data' => "action=reserve&id={$id}&douhan=yes&num=1",
                'displayText' => '1人'
              ],
              [
                'type' => 'postback',
                'label' => '2人',
                'data' => "action=reserve&id={$id}&douhan=yes&num=2",
                'displayText' => '2人'
              ],
              [
                'type' => 'postback',
                'label' => '3人',
                'data' => "action=reserve&id={$id}&douhan=yes&num=3",
                'displayText' => '3人'
              ],
              [
                'type' => 'postback',
                'label' => '追加しない',
                'data' => "action=reserve&id={$id}&douhan=yes&num=7",
                'displayText' => '追加しない'
              ],
            ]
          ]
        ]
      ]
    ];

    Http::withToken($channelAccessToken)
      ->post('https://api.line.me/v2/bot/message/reply', $body);
  }


  private function getEventInfoShort($event)
  {
    return "イベント詳細\n イベント：{$event->title}\n 日付：{$event->event_date}\n 開始時刻：{$event->start_time}\n 場所：{$event->place}";
  }
}
