<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "privacy_policy";

    protected $fillable = [
      'content',
    ];
}
