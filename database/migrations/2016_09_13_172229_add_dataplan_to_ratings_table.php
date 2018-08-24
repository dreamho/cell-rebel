<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataplanToRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ratings', 'dataplan')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->tinyInteger('dataplan')->unsigned()->default(0);
                $table->index('dataplan');
            
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
        if (Schema::hasColumn('ratings', 'dataplan')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropIndex('dataplan');
                $table->dropColumn('dataplan');
            });
        }
    }
}
