<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;

class WorldCountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE countries CASCADE;');

        $countries = config('reference.active_countries');
        foreach($countries as $country)
        {
            $capital = WorldCity::whereName($country['capital'])->first();
            $cityId = ($capital)? $capital->id : null;
            if(!($capital))
            {
                dump('Processing ' . $country['name'] . ' capital city not assigned.' );
            } else {
                dump('Processing ' . $country['name'] . ', assigning ' . $capital->name . ' as capital');
            }
            factory(WorldCountry::class)->create([
                'ncode'             => $country['ncode'],
                'code'              => $country['acode'],
                'name'              => $country['name'],
                'region'            => $country['region'],
                'subregion'         => $country['subregion'],
                'capital_city_id'   => $cityId
            ]);

        }
    }
}
