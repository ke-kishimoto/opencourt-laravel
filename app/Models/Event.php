<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "events";

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
