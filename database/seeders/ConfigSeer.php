<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            "system_title" => "from schedule",
            "bg_color" => "",
            "logo_img_path" => "",
            "waiting_flg_auto_update" => 1
        ]);
    }
}
