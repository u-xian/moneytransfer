<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('currencies')->insert([
            'country' => "Rwanda",
            'symbol' => "RWF",
            'exchange_rate' => "1",
            'phonecode' => "250",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        DB::table('currencies')->insert([
            'country' => "Uganda",
            'symbol' => "UGX",
            'exchange_rate' => "0.2335",
            'phonecode' => "256",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        DB::table('currencies')->insert([
            'country' => "Kenya",
            'symbol' => "KES",
            'exchange_rate' => "8.08131",
            'phonecode' => "254",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        DB::table('currencies')->insert([
            'country' => "Tanzania",
            'symbol' => "TZS",
            'exchange_rate' => "0.374783",
            'phonecode' => "255",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
    }
}
