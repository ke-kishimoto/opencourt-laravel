<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "policies";

    protected $fillable = [
      'policy_type',
      'content',
    ];
}
