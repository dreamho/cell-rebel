<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUxVolumeToScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('scores', 'ux_volume')) {
            Schema::table('scores', function (Blueprint $table) {
                //
                $table->integer('ux_volume')->after('ux')->unsigned()->default(0);
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
        if (Schema::hasColumn('scores', 'ux_volume')) {
            Schema::table('scores', function (Blueprint $table) {
                $table->dropColumn('ux_volume');
            });
        }
    }
}
