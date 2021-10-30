<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "event_members";

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function companions()
    {
        return $this->hasMany(EventMemberCompanion::class);
    }
}
