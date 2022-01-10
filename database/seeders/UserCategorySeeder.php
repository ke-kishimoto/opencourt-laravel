<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_categories')->insert([
            [
                "category_name" => "社会人"
            ]
        ]);
        DB::table('user_categories')->insert([
            [
                "category_name" => "大学生"
            ]
        ]);
        DB::table('user_categories')->insert([
            [
                "category_name" => "高校生"
            ]
        ]);
    }
}
