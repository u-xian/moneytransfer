<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(BlogTagsTableSeeder::class);
        $this->call(BlogPostsTableSeeder::class);
        $this->call(BlogPostTagsTableSeeder::class);
        $this->call(PostCommentsTableSeeder::class);      
    }
}
