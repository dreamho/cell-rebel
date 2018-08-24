<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileDataFilefails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('mobile_data', 'file_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->tinyInteger('file_fails')->unsigned()->default(0);                
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
        if (Schema::hasColumn('mobile_data', 'file_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropColumn('file_fails');
            });
        }
    }
}
