<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "event_users";

    protected $fillable = [
      'event_id',
      'user_id',
      'remark',
      'status',
      'attendance',
      'amount',
      'amount_remark',
    ];

    protected $appends = [
      'status_name',
      'color_status',
    ];

    public function getColorStatusAttribute()
    {
        if($this->user->status !== 'active') {
          return $this->user->status;
        }
        return $this->status;
    }

    public function getStatusNameAttribute()
    {
      if($this->status === 'participation') {
        return '参加';
      } else if ($this->status === 'cancel_waiting') {
        return 'キャンセル待ち';
      }
      return '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function companions()
    {
        return $this->hasMany(EventUserCompanion::class);
    }


}
