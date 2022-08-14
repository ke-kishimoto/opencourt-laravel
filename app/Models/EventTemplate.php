<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "event_templates";

    protected $fillable = [
      'template_name',
      'title',
      'short_title',
      'place',
      'limit_number',
      'description',
      'price1',
      'price2',
      'price3',
      'price4',
      'price5',
    ];

}
