<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileDataExtraFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add device_model, internet_type, page_load_fails, youtube_fails,
        	//youtube_rebuffering_time, youtube_quality_time, unique_id
        if (!Schema::hasColumn('mobile_data', 'device_model')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('device_model')->default('');                
            });
        }
        if (!Schema::hasColumn('mobile_data', 'internet_type')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('internet_type')->default('');  
				$table->index('internet_type');              
            });
        }
        if (!Schema::hasColumn('mobile_data', 'page_load_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->tinyInteger('page_load_fails')->unsigned()->default(0);                
            });
        }
        if (!Schema::hasColumn('mobile_data', 'youtube_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->tinyInteger('youtube_fails')->unsigned()->default(0);                
            });
        }
        if (!Schema::hasColumn('mobile_data', 'youtube_rebuffering_time')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('youtube_rebuffering_time')->default('');                
            });
        }
        if (!Schema::hasColumn('mobile_data', 'youtube_quality_time')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('youtube_quality_time')->default('');                
            });
        }
        if (!Schema::hasColumn('mobile_data', 'unique_id')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->string('unique_id')->default('');
                $table->index('unique_id');
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
        //drop device_model, internet_type, page_load_fails, youtube_fails,
        	//youtube_rebuffering_time, youtube_quality_time, unique_id
		
		if (Schema::hasColumn('mobile_data', 'device_model')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropColumn('device_model');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'internet_type')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropIndex('internet_type');
                $table->dropColumn('internet_type');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'page_load_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {               
                $table->dropColumn('page_load_fails');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'youtube_fails')) {
            Schema::table('mobile_data', function (Blueprint $table) {               
                $table->dropColumn('youtube_fails');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'youtube_rebuffering_time')) {
            Schema::table('mobile_data', function (Blueprint $table) {               
                $table->dropColumn('youtube_rebuffering_time');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'youtube_quality_time')) {
            Schema::table('mobile_data', function (Blueprint $table) {               
                $table->dropColumn('youtube_quality_time');
            });
        }
        
        if (Schema::hasColumn('mobile_data', 'unique_id')) {
            Schema::table('mobile_data', function (Blueprint $table) {
                $table->dropIndex('unique_id');
                $table->dropColumn('unique_id');
            });
        }
        
    }
}
