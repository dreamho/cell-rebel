<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceRatingToRanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('ratings', 'price_rating')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->tinyInteger('price_rating')->unsigned()->default(0);
                $table->index('price_rating');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if (Schema::hasColumn('ratings', 'price_rating')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropIndex('price_rating');
                $table->dropColumn('price_rating');
            });
        }
    }
}
