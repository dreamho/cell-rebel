<?php

use Illuminate\Database\Seeder;
use Ranking\Models\MobileOperator;
use Ranking\Models\Review;

class ReviewTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement( 'TRUNCATE TABLE reviews CASCADE;' );

        $operators = MobileOperator::get();

        foreach ( $operators as $operator ) {
            dump( 'Generating reviews for ' . ucwords( $operator->name ) );

            factory( Review::class, 5 )->create( [
                'mobile_operator_id' => $operator->id
            ] );
        }
    }
}