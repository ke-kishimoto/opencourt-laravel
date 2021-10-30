<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MemberCategory;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "members";

    public function memberCategory()
    {
        return $this->hasOne(MemberCategory::class);
    }

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }
}
