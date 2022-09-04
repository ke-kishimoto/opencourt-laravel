<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EventUser;
use App\Models\Config;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "events";

    protected $appends = [
      'day', 
      'status',
    ];

    public function getDayAttribute()
    {
      return substr($this->attributes['event_date'], 8,2);
    }

    public function getStatusAttribute()
    {
      // 終了済み
      if( $this->attributes['event_date'] < date("Y-m-d") ) {
        return 'end';
      }
      // 参加登録済み
      $user = app()->request->user();
      if($user) {
        $eventUser = EventUser::where('event_id', $this->attributes['id'])
        ->where('user_id', $user->id)->first();
        if($eventUser) {
          return $eventUser->status;
        }
      }
      // キャンセル待ち
      $eventUser = EventUser::select(DB::raw('count(*) as cnt'))
        ->where('event_id', $this->attributes['id'])->first();
      $count = !$eventUser ? 0 : $eventUser->cnt;
      if($count >= $this->attributes['limit_number']) {
        return 'waiting';
      }
      // 残り僅か
      $config = Config::find(1);
      $borderNum = (!$config) ? 5 : $config->participant_border_number;
      if($this->attributes['limit_number'] - $count <= $borderNum) {
        return 'few';
      }
      // 空きあり
      return 'afford';
    }

    public function eventUsers()
    {
        return $this->hasMany(EventUser::class);
    }

    protected $fillable = [
        'title',
        'short_title',
        'event_date',
        'start_time',
        'end_time',
        'place',
        'limit_number',
        'detail',
        'expenses',
        'amount',
        'number_of_user',
        'price1',
        'price2',
        'price3',
        'price4',
        'price5',
    ];
}
