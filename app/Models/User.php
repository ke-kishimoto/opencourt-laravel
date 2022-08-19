<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = "users";

    protected $appends = [
        'gender_name', 
        'role_name', 
        'status_name', 
        'user_category',
        'is_line_user',
    ];

    public function getGenderNameAttribute()
    {
        if(!array_key_exists('gender', $this->attributes)) {
            return '未設定'; 
        }
        if($this->attributes['gender'] === 'men') {
            return '男性';
        } else if($this->attributes['gender'] === 'women') {
            return '女性';
        } else {
            return 'その他';
        }
    }

    public function getRoleNameAttribute()
    {
        if($this->attributes['role_level'] === 'system_admin') {
            return 'システム管理者';
        } else if($this->attributes['role_level'] === 'event_admin') {
            return 'イベント管理者';
        } else {
            return '一般ユーザー';
        }
    }

    public function getStatusNameAttribute()
    {
        if($this->attributes['status'] === 'active') {
            return '有効';
        } else if($this->attributes['status'] === 'blacklist') {
            return 'ブラックリスト';
        } else {
            return 'その他';
        }
    }

    public function getIsLineUserAttribute()
    {
        return $this->line_id !== null ? true : false;
    }

    public function getUserCategoryAttribute()
    {
        return $this->userCategory();
    }

    public function userCategory()
    {
        return $this->belongsTo(UserCategory::class);
    }

    public function eventUsers()
    {
        return $this->hasMany(EventUser::class);
    }

    protected $fillable = [
        'role_level',
        'user_category_id',
        'user_name',
        'name',
        'tel',
        'password',
        'gender',
        'status',
        'description',
        'line_id',
        'line_access_token',
        'line_refresh_token',
        'remember_token',
    ];

}
