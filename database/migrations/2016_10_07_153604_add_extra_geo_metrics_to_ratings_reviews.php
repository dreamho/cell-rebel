<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraGeoMetricsToRatingsReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //city, region, organisation, timezone, zip, lat, lon
		
		//city
		if (!Schema::hasColumn('ratings', 'city')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('city')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'city')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('city')->default('');
            });
        }
        //region
        if (!Schema::hasColumn('ratings', 'region')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('region')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'region')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('region')->default('');
            });
        }
        //organisation
        if (!Schema::hasColumn('ratings', 'organisation')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('organisation')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'organisation')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('organisation')->default('');
            });
        }
        //timezone
        if (!Schema::hasColumn('ratings', 'timezone')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('timezone')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'timezone')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('timezone')->default('');
            });
        }
        //zip
        if (!Schema::hasColumn('ratings', 'zip')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('zip')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'zip')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('zip')->default('');
            });
        }
        //lat
        if (!Schema::hasColumn('ratings', 'lat')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->decimal('lat',8,4)->default(0);
            });
        }
        if (!Schema::hasColumn('reviews', 'lat')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->decimal('lat',8,4)->default(0);
            });
        }
        //lon
        if (!Schema::hasColumn('ratings', 'lon')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->decimal('lon',8,4)->default(0);
            });
        }
        if (!Schema::hasColumn('reviews', 'lon')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->decimal('lon',8,4)->default(0);
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
                //city, region, organisation, timezone, zip, lat, lon
		
		//city
		if (Schema::hasColumn('ratings', 'city')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('city');
            });
        }
        if (Schema::hasColumn('reviews', 'city')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('city');
            });
        }
        //region
        if (Schema::hasColumn('ratings', 'region')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('region');
            });
        }
        if (Schema::hasColumn('reviews', 'region')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('region');
            });
        }
        //organisation
        if (Schema::hasColumn('ratings', 'organisation')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('organisation');
            });
        }
        if (Schema::hasColumn('reviews', 'organisation')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('organisation');
            });
        }
        //timezone
        if (Schema::hasColumn('ratings', 'timezone')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('timezone');
            });
        }
        if (Schema::hasColumn('reviews', 'timezone')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('timezone');
            });
        }
        //zip
        if (Schema::hasColumn('ratings', 'zip')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('zip');
            });
        }
        if (Schema::hasColumn('reviews', 'zip')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('zip');
            });
        }
        //lat
        if (Schema::hasColumn('ratings', 'lat')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('lat');
            });
        }
        if (Schema::hasColumn('reviews', 'lat')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('lat');
            });
        }
        //lon
        if (Schema::hasColumn('ratings', 'lon')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('lon');
            });
        }
        if (Schema::hasColumn('reviews', 'lon')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('lon');
            });
        }
    }
}
