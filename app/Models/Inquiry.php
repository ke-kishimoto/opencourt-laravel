<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "inquiries";

    protected $fillable = [
      'user_id',
      'event_id',
      'title',
      'content',
      'status',
    ];

    protected $appends = [
      'status_name', 
    ];

    public function getStatusNameAttribute()
    {
        if($this->status === 'yet') {
          return '未対応';
        } else {
          return '対応済';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
