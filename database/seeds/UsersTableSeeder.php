<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
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
            $inputs= [
                    'first_name' =>  $faker->firstName($gender = null|'male'|'female'),
                    'last_name' =>  $faker->lastName,
                    'phone' =>  $faker->phoneNumber,
                    'email' =>  $faker->email,
                    'password' =>  $faker->password
            ];
            $user = Sentinel::registerAndActivate($inputs);
            unset($inputs);
        }
    }
}
