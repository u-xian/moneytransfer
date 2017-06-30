<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 10; $i++){
            DB::table('posts')->insert([ //,
                'url' => $faker->unique()->word,
                'title' => $faker->unique()->sentence($nbWords = 6),
                'description' => $faker->paragraph($nbSentences = 1),
                'content' => $faker->text,
                'image' => $faker->randomElement($array = array ('blog1.jpg','blog2.jpg','blog3.jpg')),
                'category_id' => $faker->numberBetween($min = 1, $max = 3),
                'author_id' => $faker->numberBetween($min = 1, $max = 2),
                'created_at' => Carbon::parse('2017-04-19 00:00:00'),
                'updated_at' => Carbon::parse('2017-04-19 00:00:00'),
            ]);
        }
    }
}
