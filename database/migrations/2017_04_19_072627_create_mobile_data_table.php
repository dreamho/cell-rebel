<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mobile_data', function(Blueprint $table) {
        	$table->increments('id')->unsigned();
        	
        	$table->string('ip');        	
        	$table->string('country_code');
        	$table->string('city');
        	$table->string('region');
        	$table->string('isp');
        	
        	/*
        	date - current phone datetime format  2017-04-19 14:55:03 
			os - ios/android
			os_version - os version + device name
        	*/
        	
        	$table->string('date');
        	$table->string('os');
        	$table->string('os_version');			        	
        	/*
        	file_download_time - ms
			file_download_speed - MBits
			file_ping - ping to host with file, ms
			file_url
        	*/
        	$table->string('file_download_time');
        	$table->string('file_download_speed');
        	$table->string('file_ping');
        	$table->string('file_url');        	
        	/*
        	page_load_time - ms
			page_url
        	*/
        	$table->string('page_load_time');
        	$table->string('page_url');
        	/*
        	youtube_load_time - ms
			youtube_rebufferng_count 
			youtube_extra - json-encoded all extra data from youtube playback,quality,etc
			youtube_url
        	*/
        	$table->string('youtube_load_time');
        	$table->string('youtube_rebufferng_count');
        	$table->text('youtube_extra');
        	$table->string('youtube_url');
        	/*
        	lat
			lon
        	*/
        	$table->string('lat');
        	$table->string('lon');
        	/*
        	cell_id
			mnc
			mcc
			
			connection_type
			carrier - operator name/carrier
			signal_strength - (string because of unknown format)
        	*/
        	$table->integer('cell_id');
        	$table->integer('mnc');
        	$table->integer('mcc');
        	
        	$table->string('connection_type');
        	$table->string('carrier');
        	$table->string('signal_strength');
        	/*
        	call_drops
			call_blocks
			total_calls
        	*/
        	$table->integer('call_drops');
        	$table->integer('call_blocks');
        	$table->integer('total_calls');
        	
        	$table->text('raw_data');
        	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('mobile_data');
    }
}
