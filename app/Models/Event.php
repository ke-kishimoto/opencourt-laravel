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
      return '1';
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
