<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member_categories')->insert([
            [
                "category_name" => "社会人"
            ]
        ]);
        DB::table('member_categories')->insert([
            [
                "category_name" => "大学生"
            ]
        ]);
        DB::table('member_categories')->insert([
            [
                "category_name" => "高校生"
            ]
        ]);
    }
}
