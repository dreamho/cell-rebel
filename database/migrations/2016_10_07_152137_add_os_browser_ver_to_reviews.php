<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOsBrowserVerToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('reviews', 'browser_version')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('browser_version')->default('');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'os')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('os')->default('');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'os_version')) {
            Schema::table('reviews', function (Blueprint $table) {
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
        if (Schema::hasColumn('reviews', 'browser_version')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('browser_version');
            });
        }
        if (Schema::hasColumn('reviews', 'os')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('os');
            });
        }
        if (Schema::hasColumn('reviews', 'os_version')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('os_version');
            });
        }
    }
}
