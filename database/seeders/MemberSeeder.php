<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            "role_level" => 1,
            "email" => "super@test.com",
            "name" => "super",
            "password" => Hash::make("password"),
            "category_id" => 1,
            "gender" => 1,
        ]);
        DB::table('members')->insert([
            "role_level" => 1,
            "email" => "nebinosuk@gmail.com",
            "name" => "kishimoto keisuke",
            "password" => Hash::make("password"),
            "category_id" => 1,
            "gender" => 1,
        ]);
        DB::table('members')->insert([
            "role_level" => 2,
            "email" => "admin@admin.com",
            "name" => "admin",
            "password" => Hash::make("password"),
            "category_id" => 1,
            "gender" => 1,
        ]);
        DB::table('members')->insert([
            "role_level" => 3,
            "email" => "test1@test.com",
            "name" => "test1",
            "password" => Hash::make("password"),
            "category_id" => 1,
            "gender" => 1,
        ]);
        DB::table('members')->insert([
            "role_level" => 3,
            "email" => "test2@test.com",
            "name" => "test2",
            "password" => Hash::make("password"),
            "category_id" => 1,
            "gender" => 1,
        ]);
    }
}
