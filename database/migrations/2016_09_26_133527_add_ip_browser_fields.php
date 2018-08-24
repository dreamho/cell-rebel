<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpBrowserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('ratings', 'ip')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('ip')->default('');
                $table->index('ip');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'browser')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('browser')->default('');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'ip')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('ip')->default('');
                $table->index('ip');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'browser')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('browser')->default('');
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
        if (Schema::hasColumn('ratings', 'ip')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropIndex('ip');
                $table->dropColumn('ip');
            });
        }
        
        if (Schema::hasColumn('ratings', 'browser')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('browser');
            });
        }
        
        if (Schema::hasColumn('reviews', 'ip')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropIndex('ip');
                $table->dropColumn('ip');
            });
        }
        
        if (Schema::hasColumn('reviews', 'browser')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('browser');
            });
        }
    }
}
