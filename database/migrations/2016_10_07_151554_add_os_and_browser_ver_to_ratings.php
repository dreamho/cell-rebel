<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOsAndBrowserVerToRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ratings', 'browser_version')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('browser_version')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'os')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('os')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'os_version')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('os_version')->default('');
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
        if (Schema::hasColumn('ratings', 'browser_version')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('browser_version');
            });
        }
        if (Schema::hasColumn('ratings', 'os')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('os');
            });
        }
        if (Schema::hasColumn('ratings', 'os_version')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('os_version');
            });
        }
    }
}
