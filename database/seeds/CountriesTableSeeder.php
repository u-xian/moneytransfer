<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/country.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          DB::table('countries')->insert([
            'iso_abbr' => $obj->iso_abbr,
            'name' => $obj->name,
            'nicename' => $obj->nicename,
            'iso_name' => $obj->iso_name,
            'numcode' => $obj->numcode,
            'phonecode' => $obj->phonecode,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }        
    }
}
