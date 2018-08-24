<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('timeperiod');
            $table->integer('country_id')->unsigned();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('mobile_operator_id')->unsigned();
            $table->float('ux')->defualt(0);
            $table->float('price')->defualt(0);
            $table->float('web_browsing')->defualt(0);
            $table->float('video')->default(0);
            $table->float('data_dl')->default(0);
            $table->float('data_ul')->default(0);
            $table->float('wb_avg_pgldtime')->default(0);
            $table->float('wb_wrst10p_pgldtime')->default(0);
            $table->float('wb_avg_failrate')->default(0);
            $table->float('video_avg_starttime')->default(0);
            $table->float('video_wrst10p_starttime')->default(0);
            $table->float('video_avg_rebuffering')->default(0);
            $table->float('video_avg_bit_rate')->default(0);
            $table->float('data_dl_avg_speed')->default(0);
            $table->float('data_dl_wrst10p_speed')->default(0);
            $table->float('data_ud_avg_speed')->default(0);
            $table->float('data_ud_wrst10p_speed')->default(0);
            $table->string('score_for',1)->default('C');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
