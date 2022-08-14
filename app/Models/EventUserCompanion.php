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

    protected $appends = [
      'gender_name', 
      'user_category',
    ];

    public function getGenderNameAttribute()
    {
        if($this->attributes['gender'] === 1) {
            return '男性';
        } else if($this->attributes['gender'] === 2) {
            return '女性';
        } else {
            return 'その他';
        }
    }

    public function eventUser()
    {
        return $this->belongsTo(EventUser::class);
    }

    public function getUserCategoryAttribute()
    {
        return $this->userCategory();
    }

    public function userCategory()
    {
        return $this->belongsTo(UserCategory::class);
    }

}
