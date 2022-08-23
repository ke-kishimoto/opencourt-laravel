<?php

namespace Tests;

use App\Models\UserCategory;
use App\Models\EventTemplate;

class DBTestUtil
{
  public static function createCategory()
  {
    UserCategory::truncate();

    UserCategory::create([
      'category_name' => '社会人',
    ]);

    UserCategory::create([
      'category_name' => '大学生',
    ]);

    UserCategory::create([
      'category_name' => '高校生',
    ]);

    UserCategory::create([
      'category_name' => '中学生',
    ]);

    UserCategory::create([
      'category_name' => '小学生',
    ]);
  }

  public static function createTemplate()
  {
    
    EventTemplate::truncate();

    EventTemplate::factory()->create([]);
    EventTemplate::factory()->create([]);
    EventTemplate::factory()->create([]);

  }
}