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
            'event_date' => '2021/12/10',
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'detail' => 'みんなでバスケする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_member' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => 'サッカー1',
            'short_title' => 'サッカー1',
            'event_date' => '2021/12/15',
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'detail' => 'みんなでサッカーする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_member' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => '野球1',
            'short_title' => '野球1',
            'event_date' => '2021/12/20',
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'detail' => 'みんなで野球する',
            'expenses' => 0,
            'amount' => 0,
            'number_of_member' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
        DB::table('events')->insert([
            'title' => 'バレー1',
            'short_title' => 'バレー1',
            'event_date' => '2021/12/20',
            'start_time' => '14:00',
            'end_time' => '18:00',
            'place' => '那覇市',
            'limit_number' => 10,
            'detail' => 'みんなでバレーする',
            'expenses' => 0,
            'amount' => 0,
            'number_of_member' => 10,
            'price1' => 1,
            'price2' => 2,
            'price1' => 3,
            'price1' => 4,
            'price1' => 5,
        ]);
    }
}
