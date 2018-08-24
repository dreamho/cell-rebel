<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviceExtraFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
		//form_factor,is_wireless_device,pointing_method,brand_name,model_name,useragent
		
		if (!Schema::hasColumn('ratings', 'form_factor')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('form_factor')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'form_factor')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('form_factor')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'is_wireless_device')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('is_wireless_device')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'is_wireless_device')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('is_wireless_device')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'pointing_method')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('pointing_method')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'pointing_method')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('pointing_method')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'brand_name')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('brand_name')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'brand_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('brand_name')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'model_name')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('model_name')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'model_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('model_name')->default('');
            });
        }
        
        if (!Schema::hasColumn('ratings', 'useragent')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->string('useragent')->default('');
            });
        }
        if (!Schema::hasColumn('reviews', 'useragent')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('useragent')->default('');
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
        //form_factor,is_wireless_device,pointing_method,brand_name,model_name,useragent
        
        if (Schema::hasColumn('ratings', 'form_factor')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('form_factor');
            });
        }
        if (Schema::hasColumn('reviews', 'form_factor')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('form_factor');
            });
        }
        if (Schema::hasColumn('ratings', 'is_wireless_device')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('is_wireless_device');
            });
        }
        if (Schema::hasColumn('reviews', 'is_wireless_device')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('is_wireless_device');
            });
        }
        if (Schema::hasColumn('ratings', 'pointing_method')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('pointing_method');
            });
        }
        if (Schema::hasColumn('reviews', 'pointing_method')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('pointing_method');
            });
        }
        if (Schema::hasColumn('ratings', 'brand_name')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('brand_name');
            });
        }
        if (Schema::hasColumn('reviews', 'brand_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('brand_name');
            });
        }
        if (Schema::hasColumn('ratings', 'model_name')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('model_name');
            });
        }
        if (Schema::hasColumn('reviews', 'model_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('model_name');
            });
        }
        if (Schema::hasColumn('ratings', 'useragent')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->dropColumn('useragent');
            });
        }
        if (Schema::hasColumn('reviews', 'useragent')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('useragent');
            });
        }
        
    }
}
