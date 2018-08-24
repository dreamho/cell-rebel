<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUxRatingToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('reviews', 'ux_rating')) {
            Schema::table('reviews', function (Blueprint $table) {
                //
                $table->integer('ux_rating')->after('isp')->unsigned()->default(0);
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
        if (Schema::hasColumn('reviews', 'ux_rating')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('ux_rating');
            });
        }
    }
}
