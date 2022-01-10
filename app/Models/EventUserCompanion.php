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

    public function eventUser()
    {
        return $this->belongsTo(EventUser::class);
    }

}
