<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'title' => 'バスケットボール1',
            'short_title' => 'バスケ1',
            'event_date' => date('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'description' => 'みんなでバスケする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_user' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => 'サッカー1',
            'short_title' => 'サッカー1',
            'event_date' => date('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'description' => 'みんなでサッカーする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_user' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => '野球1',
            'short_title' => '野球1',
            'event_date' => date('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'description' => 'みんなで野球する',
            'expenses' => 0,
            'amount' => 0,
            'number_of_user' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => 'バレー1',
            'short_title' => 'バレー1',
            'event_date' => date('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'description' => 'みんなでバレーする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_user' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
    }
}
