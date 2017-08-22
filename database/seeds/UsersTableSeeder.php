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
            $inputs= [
                    'email' =>  'admin@moneytransfer.com',
                    'password' =>  '123456',
                    'is_admin' => 1
            ];
            $user = Sentinel::registerAndActivate($inputs);
    }
}
