<?php

namespace Database\Factories;

use App\Models\EventTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'template_name' =>  'サンプルテンプレート',
          'title' => 'サンプルイベント名',
          'short_title' => 'サンプルイベント略称',
          'place' => 'サンプル場所',
          'limit_number' => '30',
          'description' => '詳細サンプル',
          'price1' => 500,
          'price2' => 400,
          'price3' => 300,
          'price4' => 200,
          'price5' => 100,
        ];
    }

   
}
