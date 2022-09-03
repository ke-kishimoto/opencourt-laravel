<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "configs";

    protected $fillable = [
        'line_notify_flag',
        'waiting_status_auto_update_flag',
        'participant_border_number',
    ];
}
