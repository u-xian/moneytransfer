<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlogPostTagsTableSeeder extends Seeder
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

        for ($i = 1; $i < 11; $i++){
            DB::table('blog_post_tags')->insert([ //,
                'post_id' => $i,
                'tag_id' => $faker->numberBetween($min = 1, $max = 2),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
