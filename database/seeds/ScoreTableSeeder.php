<?php

use Illuminate\Database\Seeder;
use Ranking\Models\MobileOperator;
use Ranking\Models\Scores;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;

class ScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE scores CASCADE;');
        $faker = Faker\Factory::create();
//        $countries = WorldCountry::whereNotNull('capital_city_id')->get();
        $countries = WorldCountry::get();

        $timeperiod = date('Ym');

        foreach($countries as $country)
        {
            dump('Generating scores for '. $country->name . ' ...');
            if(!is_null($country->capital_city_id)) {
                $cities = WorldCity::where('id', '!=', $country->capital_city_id)
                    ->whereCode($country->code)
                    ->lists('id')->toArray();
                $cities = array_filter($cities);
            }

            $operators = MobileOperator::whereCountryCode($country->code)->get();
            $operatorIds = MobileOperator::whereCountryCode($country->code)->lists('id')->toArray();

            /* Create Scores for National & Capital */
            foreach($operators as $operator)
            {
                factory(Scores::class)->create([
                    'timeperiod'            => $timeperiod,
                    'country_id'            => $country->id,
                    'city_id'               => $country->capital_city_id,
                    'mobile_operator_id'    => $operator->id,
                    'score_for'             => 'N'
                ]);

                if(!is_null($country->capital_city_id)) {
                    factory(Scores::class)->create([
                        'timeperiod'         => $timeperiod,
                        'country_id'         => $country->id,
                        'city_id'            => $country->capital_city_id,
                        'mobile_operator_id' => $operator->id,
                        'score_for'          => 'C'
                    ]);
                }
            }

            /* Create Scores for other cities */
            if(!empty($cities)) {
                for ($i=0; $i<=2; $i++)
                {
                    foreach($operators as $operator)
                    {
                        factory(Scores::class)->create([
                            'timeperiod'         => $timeperiod,
                            'country_id'         => $country->id,
                            'city_id'            => $faker->randomElement($cities),
                            'mobile_operator_id' => $operator->id,
                            'score_for'          => 'C'
                        ]);
                    }
                }
            }

        }
    }

}
