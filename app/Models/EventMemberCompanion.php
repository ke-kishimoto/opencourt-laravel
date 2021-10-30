<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventMemberCompanion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "event_member_companions";

    public function eventMember()
    {
        return $this->belongsTo(eventMember::class);
    }
}
