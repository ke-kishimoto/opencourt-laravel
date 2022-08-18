<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "name" => "super_user",
            "role_level" => 'system_admin',
            "email" => "super@test.com",
            "password" => Hash::make("password"),
            "user_category_id" => 1,
            "gender" => 'men',
            "status" => 'active',
        ]);
        DB::table('users')->insert([
            "role_level" => 'general',
            "email" => "nebinosuk@gmail.com",
            "name" => "kishimoto keisuke",
            "password" => Hash::make("password"),
            "user_category_id" => 1,
            "gender" => 'men',
            "status" => 'active',
        ]);
        DB::table('users')->insert([
            "role_level" => 'general',
            "email" => "k.kishimoto@tc-tech.co.jp",
            "name" => "tc-kishimoto",
            "password" => Hash::make("password"),
            "user_category_id" => 1,
            "gender" => 'men',
            "status" => 'active',
        ]);
        DB::table('users')->insert([
            "name" => "event_user",
            "role_level" => 'event_admin',
            "email" => "admin@admin.com",
            "password" => Hash::make("password"),
            "user_category_id" => 1,
            "gender" => 'men',
            "status" => 'active',
        ]);
    }
}
