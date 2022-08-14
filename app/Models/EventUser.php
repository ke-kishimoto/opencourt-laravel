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

    public function user()
    {
        return $this->hasOne(User::class);
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
