<?php

use Illuminate\Database\Seeder;
use Ranking\Models\MobileOperator;

class MobileOperatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE mobile_operators CASCADE;');

        $operators = config('reference.operators');

        foreach($operators as $operator)
        {
            dump('Adding ' . $operator['name'] . '...' );
            factory(MobileOperator::class)->create([
                'country_code' => $operator['ncode'],
                'name'  => strtoupper($operator['name'])
            ]);
        }
    }
}
