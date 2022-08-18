<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_templates')->insert([
            "template_name" => "バスケテンプレ",
            "title" => "バスケットボール",
            "short_title" => "バスケ",
            "place" => "沖縄県沖縄市",
            "limit_number" => 10,
            "description" => "みんなでバスケする",
            "price1" => 100,
            "price2" => 200,
            "price3" => 300,
            "price4" => 400,
            "price5" => 500,
        ]);

        DB::table('event_templates')->insert([
            "template_name" => "サッカーテンプレ",
            "title" => "サッカー",
            "short_title" => "サッカー",
            "place" => "沖縄県那覇市",
            "limit_number" => 10,
            "description" => "みんなでサッカーする",
            "price1" => 100,
            "price2" => 200,
            "price3" => 300,
            "price4" => 400,
            "price5" => 500,
        ]);

        DB::table('event_templates')->insert([
            "template_name" => "野球テンプレ",
            "title" => "野球",
            "short_title" => "野球",
            "place" => "宜野湾",
            "limit_number" => 10,
            "description" => "みんなで野球する",
            "price1" => 100,
            "price2" => 200,
            "price3" => 300,
            "price4" => 400,
            "price5" => 500,
        ]);

        DB::table('event_templates')->insert([
            "template_name" => "バレーテンプレ",
            "title" => "バレー",
            "short_title" => "バレー",
            "place" => "沖縄県",
            "limit_number" => 10,
            "description" => "みんなでバスケする",
            "price1" => 100,
            "price2" => 200,
            "price3" => 300,
            "price4" => 400,
            "price5" => 500,
        ]);

        DB::table('event_templates')->insert([
            "template_name" => "バドミントンテンプレ",
            "title" => "バドミントン",
            "short_title" => "バドミントン",
            "place" => "沖縄県沖縄市",
            "limit_number" => 10,
            "description" => "みんなでバドミントンする",
            "price1" => 100,
            "price2" => 200,
            "price3" => 300,
            "price4" => 400,
            "price5" => 500,
        ]);
    }
}
