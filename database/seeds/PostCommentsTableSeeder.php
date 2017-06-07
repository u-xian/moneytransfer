<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostCommentsTableSeeder extends Seeder
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

        for ($i = 0; $i < 10; $i++){
            DB::table('blog_post_comments')->insert([ //,   
                'on_post' => $faker->numberBetween($min = 1, $max = 8),
                'names'=>  $faker->name($gender = null|'male'|'female'),
                'email' => $faker->email,
                'body' => $faker->text,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
