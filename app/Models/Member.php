<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MemberCategory;

class Member extends Model
{
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;

    protected $table = "members";

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

    public function getRoleNameAttribute()
    {
        if($this->attributes['role_level'] === 1) {
            return 'システム管理者';
        } else if($this->attributes['role_level'] === 2) {
            return 'イベント管理者';
        } else {
            return '一般ユーザー';
        }
    }

    public function getStatusNameAttribute()
    {
        if($this->attributes['status'] === 1) {
            return '有効';
        } else if($this->attributes['status'] === 2) {
            return 'ブラックリスト';
        } else {
            return 'その他';
        }
    }

    public function getIsLineUserAttribute()
    {
        return $this->line_id !== null ? true : false;
    }

    public function getMemberCategoryAttribute()
    {
        return $this->memberCategory();
    }

    protected $appends = [
        'gender_name', 
        'role_name', 
        'status_name', 
        'member_category',
        'is_line_user',
    ];

    public function memberCategory()
    {
        return $this->belongsTo(MemberCategory::class);
    }

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }
}
