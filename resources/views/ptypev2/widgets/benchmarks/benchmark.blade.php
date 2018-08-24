<script type="text/javascript" src="//cdn.jsdelivr.net/fingerprintjs2/1.5.1/fingerprint2.min.js"></script>
<script type="text/javascript">
		
		var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        
		var SpeedTest = {
			imageAddr:"{{$test_file_link}}",
			siteAddr:"{{ $test_site_link }}",
			youtubeID:"{{$youtube_video_id}}",
			downloadSize:{{$test_file_size}}, //bytes
			speedTestStartTime:null,
			speedTestEndTime:null,
			siteTestStartTime:null,
			siteTestEndTime:null,
			averageSpeed:-1,
			player:null,
			youtubeStartLoadingTime:null,
			youtubeStartTime:null,
			youtubeStartPlayTime:null,
			youtubeEndPlayTime:null,
			youtubeQuality:[],
			buffenringTimes:0,
			siteLoadTime:0,
			start:function(){
				$('.speedtest-title').addClass('hidden');
				$('.speedtest-progress').addClass('hidden');
				$('.speedtest-result').addClass('hidden');				
				$('.siteload-result').addClass('hidden');
				$('.youtube-test-start').addClass('hidden');
				$('.youtube-log').addClass('hidden');
				$('.youtube-progress').addClass('hidden');
				$('.youtube-progress .progress-bar').removeClass('active');
				
				$('#startTest').addClass('hidden');
				$('.speedtest_wait_msg').removeClass('hidden');
				
				this.startSpeedTest();
			},
			
			persistData:function(){
				var data = {};
				
				data['file_speed'] = SpeedTest.averageSpeed;
				data['site_load'] = SpeedTest.siteLoadTime;
				if(SpeedTest.iOS==false){
					data['youtube_buffering_time'] = SpeedTest.youtubeStartPlayTime-SpeedTest.youtubeStartTime;
					data['youtube_buffering_count'] = SpeedTest.buffenringTimes;
					data['youtube_quality'] = SpeedTest.youtubeQuality;
				} else {
					data['youtube_buffering_time'] = -1;
					data['youtube_buffering_count'] = -1;
					data['youtube_quality'] = '';
				}
				data['file_fails'] = SpeedTest.fileFails;
				data['unique_id'] = SpeedTest.fingerprint;				
				data['file_download_time'] = SpeedTest.fileLoadTime;
				
				$.ajax({
					url:'/api/persistBenchmark',
					data:data,
					type:'post',
					dataType:'json',
					success:function(resp){
						console.log(resp);
					}	
				});
				
			},
			
			end:function(){
				$('#startTest').removeClass('hidden');
				$('.speedtest_wait_msg').addClass('hidden');
				if(SpeedTest.iOS==false){
					SpeedTest.logYoutube(SpeedTest.buffenringTimes+' buffering times');
				}
				
				$('#startTest').text('Test again');
				
				SpeedTest.persistData();
			},			
			
			onPlayerReady:function(event) {
				event.target.playVideo();
	        },

			stopVideo:function() {
				this.player.stopVideo();
			},

			getPlaybackQuality:function() {
				return this.player.getPlaybackQuality();
			},
			logYoutube:function(msg){
				var logContainer = $('.youtube-log-value');
				$('<span></span>').html(msg).appendTo(logContainer);
				$('<br/>').appendTo(logContainer);
			},
			onPlayerStateChange:function(event) {
				event.target.mute();
				
				var me = SpeedTest;
				if (event != null && typeof event != typeof "undefined") {
					switch (event.data) {
						case -1:							
						break;	
						case YT.PlayerState.CUED:							
							me.youtubeStartTime = (new Date()).getTime();
							SpeedTest.logYoutube((me.youtubeStartTime-me.youtubeStartLoadingTime)+'ms: started');
							break;
						case YT.PlayerState.BUFFERING:
							var buffTime = (new Date()).getTime();
							SpeedTest.logYoutube((buffTime-me.youtubeStartLoadingTime)+'ms: buffering');
							me.buffenringTimes+=1;
							SpeedTest.player.playVideo();
							break;
						case YT.PlayerState.PLAYING:						
							me.youtubeStartPlayTime = (new Date()).getTime();
							SpeedTest.logYoutube((me.youtubeStartPlayTime-me.youtubeStartLoadingTime)+'ms: playing');
							break;
						case YT.PlayerState.ENDED:
							me.youtubeEndPlayTime = (new Date()).getTime();
							SpeedTest.logYoutube((me.youtubeEndPlayTime-me.youtubeStartLoadingTime)+'ms: stopped');
							$('.youtube-progress .progress-bar').removeClass('active');
							me.end();
							break;
					}
				}
			},

			onError:function(event) {
				console.log('youtube_error',event);
			},
			previousYoutubeQualityTime:-1,
			previousYoutubeQuality:'',
			
			
		
			onPlaybackQualityChange:function(event) {
				console.log('youtube_quality',event);
				var nowtime = (new Date()).getTime();
				var changeQualityTime = (nowtime-SpeedTest.youtubeStartLoadingTime);
				var previousQualityDuration = 0; 
				var previousQuality = SpeedTest.previousYoutubeQuality;
				if(SpeedTest.previousYoutubeQualityTime>0){
					previousQualityDuration = nowtime - SpeedTest.previousYoutubeQualityTime; 
				} else {
					previousQualityDuration = 0;
				}
				SpeedTest.previousYoutubeQualityTime = nowtime;
				SpeedTest.previousYoutubeQuality = event.data;
				
				SpeedTest.logYoutube(changeQualityTime+'ms: quality '+SpeedTest.previousYoutubeQuality);
				SpeedTest.youtubeQuality.push({
					quality:event.data,
					time:changeQualityTime,
					previous_quality:previousQuality,
					previous_duration:previousQualityDuration
				});
				console.log(SpeedTest.youtubeQuality);
			},
			iOS:false,
			startYoutubeTest:function(){
				
				SpeedTest.iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
				
				if(SpeedTest.iOS){
					SpeedTest.end();
					return false;
				}
				
				this.youtubeQuality = [];
				this.previousYoutubeQualityTime = -1;
			    this.previousYoutubeQuality = '',
				$('.youtube-test-start').removeClass('hidden');
				$('.youtube-log').removeClass('hidden');
				$('.youtube-log-value').html('');
				$('.youtube-progress').removeClass('hidden');
				$('.youtube-progress .progress-bar').addClass('active');
				
				var containerID = 'pl_'+(new Date()).getTime();
				$('#player').html('');
				$('<div></div>').attr('id',containerID).appendTo('#player');
				
				
				this.youtubeStartLoadingTime = (new Date()).getTime();
				this.logYoutube('0ms: loading started');
				this.buffenringTimes = 0;
				
					this.player = new YT.Player(containerID, {
			            height: '1',
			            width: '1',
						videoId: this.youtubeID,
			            events: {
			                'onReady': this.onPlayerReady,
							'onStateChange': this.onPlayerStateChange,
							'onError': this.onError,
							'onPlaybackQualityChange': this.onPlaybackQualityChange
	      				}
		            });
	            
				
			},		
			startSiteLoadSpeedTest:function(){
				$('#iframe_wrap').html('');
				var me = this;
				var ifr = $('<iframe/>', {
		            id:'MainPopupIframe',
		            src:this.siteAddr,
		            style:'display:none',
		            load:function(){
		            	me.siteTestEndTime = (new Date()).getTime();		                
		                me.endSiteLoadSpeedTest(me.siteTestEndTime - me.siteTestStartTime);
		            }
		        });
		        me.siteTestStartTime = (new Date()).getTime();
		        $('#iframe_wrap').append(ifr);
			},
			endSiteLoadSpeedTest:function(milliseconds){
				$('#iframe_wrap').html('');
				var seconds = (milliseconds/1000).toFixed(3);
				this.siteLoadTime = seconds;
				$('.siteload-result-value').html(seconds);
				$('.siteload-result').removeClass('hidden');
				$('.siteload-result .site-name').html(this.siteAddr);
				this.startYoutubeTest();
			},
			fileLoads:0,
			fileLoadTime:0,
			startSpeedTest:function(){
				this.fileFails = 0;
				$('.speedtest-title').removeClass('hidden');
				$('.speedtest-progress').removeClass('hidden');
				
				$('.speedtest-progress .progress-percent').html('5');
				$('.speedtest-progress .progress-bar').addClass('active').attr('aria-valuenow',5).css({
					width:'5%'
				});
				
				
				var me = this;
				me.averageSpeed = 0;
				me.fileLoads = 0;
				me.fileLoadTime = 0;
				this.measureSpeed(function(megabits,seconds){
					if(megabits>0){
						me.fileLoads++;
						me.averageSpeed+=megabits;
						me.fileLoadTime+=seconds;
					}
					
					$('.speedtest-progress .progress-percent').html('30');
					$('.speedtest-progress .progress-bar').attr('aria-valuenow',30).css({
						width:'33%'
					});
					me.measureSpeed(function(megabits,seconds){
						if(megabits>0){
							me.fileLoads++;
							me.averageSpeed+=megabits;
							me.fileLoadTime+=seconds;
						}
						
						$('.speedtest-progress .progress-percent').html('60');
						$('.speedtest-progress .progress-bar').attr('aria-valuenow',60).css({
							width:'67%'
						});
						me.measureSpeed(function(megabits,seconds){
							if(megabits>0){
								me.fileLoads++;
								me.averageSpeed+=megabits;
								me.fileLoadTime+=seconds;
							}
							me.averageSpeed/=me.fileLoads;
							me.fileLoadTime/=me.fileLoads;		
							me.endSpeedTest();					
						});
					});
				});
			},
			fingerprint:'',
			initFingerprint:function(){
				var me = this;
				new Fingerprint2().get(function(result, components){
				  me.fingerprint = result;
				});	
			},
			endSpeedTest:function(){
				$('.speedtest-progress .progress-percent').html('100');
				$('.speedtest-progress .progress-bar').attr('aria-valuenow',100).css({
					width:'100%'
				}).removeClass('active');
				$('.speedtest-result').removeClass('hidden');
				this.averageSpeed = this.averageSpeed.toFixed(2);
				this.fileLoadTime = this.fileLoadTime*1000;
				$('.speedtest-result-value').html(this.averageSpeed);
				this.initFingerprint();
				this.startSiteLoadSpeedTest();
			},
			ShowProgressMessage:function(msg) {
			    if (console) {
			        if (typeof msg == "string") {
			            console.log(msg);
			        } else {
			            for (var i = 0; i < msg.length; i++) {
			                console.log(msg[i]);
			            }
			        }
			    }
		    },
		    fileFails:0,		    
		    measureSpeed:function(callback){
		    	var download = new Image();
			    var me = this;
			    download.onload = function () {
			        me.speedTestEndTime = (new Date()).getTime();
       				
       				var duration = (me.speedTestEndTime - me.speedTestStartTime) / 1000;
			        var bitsLoaded = me.downloadSize * 8;
			        var speedBps = (bitsLoaded / duration).toFixed(2);
			        var speedKbps = (speedBps / 1024).toFixed(2);
			        var speedMbps = (speedKbps / 1024).toFixed(2);
			        me.ShowProgressMessage([
			            "Your connection speed is:", 
			            speedBps + " bps", 
			            speedKbps + " kbps", 
			            speedMbps + " Mbps"
			        ]);
			        callback(speedMbps*1,duration*1);
       				
			    }
			    
			    download.onerror = function (err, msg) {
			        me.ShowProgressMessage("Invalid image, or error downloading");
			        me.fileFails++;
			        callback(-1);
			    }
			    
			    me.speedTestStartTime = (new Date()).getTime();
			    var cacheBuster = "?nnn=" + me.speedTestStartTime;
			    download.src = this.imageAddr + cacheBuster;
		    }
		};
	
</script>

<div class="row">
	<div class="col-lg-6 col-lg-offset-2">
		<div class="well">
		
			<div class="row text-center speedtest-title hidden">
				<div class="col-lg-12">
					<strong>DOWNLOAD SPEED:</strong>
				</div>
			</div>
			
			<div class="row speedtest-progress hidden">
				<div class="col-lg-12">
					<div class="progress">
				  		<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				    		<span class="sr-only"><span class="progress-percent">0</span>% Complete</span>
				  		</div>
					</div>
				</div>
			</div>
			
			<div class="row speedtest-result hidden">
				<div class="col-lg-12">
					<strong>Your connection speed is: <span class="speedtest-result-value">0</span> Mbit/s!</strong>
				</div>
			</div>
			
			<div class="row siteload-result hidden">
				<div class="col-lg-12">
					<strong>It took <span class="siteload-result-value">0</span> seconds to load <span class="site-name"></span></strong>
				</div>
			</div>
			
			<div class="row youtube-test-start hidden">
				<div class="col-lg-12">
					<strong>Youtube test started</strong>
				</div>
			</div>
			
			<div class="row youtube-progress hidden">
				<div class="col-lg-12">
					<div class="progress">
				  		<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    		
				  		</div>
					</div>
				</div>
			</div>
			
			<div class="row youtube-log hidden">
				<div class="col-lg-12">
					<div class="youtube-log-value"></div>
				</div>
			</div>
			
			<div class="row text-center">
				<div class="col-lg-12">					
					<a href="#" class="btn btn-default" id="startTest" onclick="SpeedTest.start(); return false;">TEST CONNECTION</a>
					<strong class="speedtest_wait_msg hidden">PLEASE WAIT...</strong>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div id="iframe_wrap" style="width: 1px; height: 1px; overflow: hidden; opacity: 0;"></div>
<div id="player" style="width: 1px; height: 1px;  overflow: hidden; opacity: 0;"></div>