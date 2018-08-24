<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileDataConnectionDurationsAndRemoveYoutubeExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('mobile_data', 'connection_durations')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('connection_durations')->default('');                
            });
        }
        if (Schema::hasColumn('mobile_data', 'youtube_extra')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropColumn('youtube_extra');
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
        if (Schema::hasColumn('mobile_data', 'connection_durations')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropColumn('connection_durations');
            });
        }
    }
}
