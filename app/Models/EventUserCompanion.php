<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventUserCompanion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "event_user_companions";

    protected $fillable = [
      'event_id',
      'event_user_id',
      'user_category_id',
      'gender',
      'name',
      'status',
      'attendance',
      'amount',
      'amount_remark',
    ];


    public function eventUser()
    {
        return $this->belongsTo(EventUser::class);
    }

}
