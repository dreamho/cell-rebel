<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryCodeAndIsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('ratings', 'country_code')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('country_code')->after('mobile_operator_id')->default('');
                $table->index('country_code');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'isp')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('isp')->after('browser')->default('');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'country_code')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('country_code')->after('mobile_operator_id')->default('');
                $table->index('country_code');
            });
        }
        
        if (!Schema::hasColumn('reviews', 'isp')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('isp')->after('browser')->default('');
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
        if (Schema::hasColumn('ratings', 'country_code')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropIndex('country_code');
                $table->dropColumn('country_code');
            });
        }
        
        if (Schema::hasColumn('ratings', 'isp')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('isp');
            });
        }
        
        if (Schema::hasColumn('reviews', 'country_code')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropIndex('country_code');
                $table->dropColumn('country_code');
            });
        }
        
        if (Schema::hasColumn('reviews', 'isp')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('isp');
            });
        }
    }
}
