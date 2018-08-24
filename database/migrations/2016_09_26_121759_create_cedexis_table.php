<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCedexisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cedexis', function (Blueprint $table) {
            //
            $table->increments('id')->unsigned();
            $table->date('date');
            $table->string('operator');
            $table->string('country');
            $table->float('avg_load_time')->default(0);
            $table->float('avg_failure_rate')->default(0);
            $table->float('unique_sessions')->default(0);
            $table->float('25th_percentile_load_time')->default(0);
            $table->float('50th_percentile_load_time')->default(0);
            $table->float('75th_percentile_load_time')->default(0);
            $table->float('95th_percentile_load_time')->default(0);      
            
            $table->index('date');      
            $table->index('operator');
            $table->index('country'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cedexis');
    }
}
