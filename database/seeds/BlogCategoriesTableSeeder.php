<?php

use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('blog_categories')->insert([
            'category' => "WOMEN"
        ]);

        DB::table('blog_categories')->insert([
            'category' => "MEN"
        ]);

        DB::table('blog_categories')->insert([
            'category' => "KIDS"
        ]);
    }
}
