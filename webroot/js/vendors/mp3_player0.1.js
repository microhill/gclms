/*
   JavaScript MP3 Player
   --------------------------------------------
   http://www.utahwebdev.com/aaron/jsmp3player

   Copyright (c) 2007, Aaron Shafovaloff. All rights reserved.
   Code licensed under the BSD License:
   http://www.utahwebdev.com/aaron/jsmp3player#license

   Version 0.1
*/

var MP3Player = Class.create();
MP3Player.prototype = {
	initialize: function(element) {
		element = $(element);
		
		this.soundManagerName = 'sound' + Math.random();
		this.playButton =  element.getElementsByClassName('play').first();
		this.progressTrack =  element.getElementsByClassName('progressTrack').first();
		this.newValue = null;
		
		this.slider = new Control.Slider(
				element.getElementsByClassName('handle').first(),element.getElementsByClassName('transparentTrack').first(),{
			onChange: this.update.bind(this),
			onSlide: this.update.bind(this)
		});

		this.soundManager = soundManager.createSound({
			id: this.soundManagerName,
			url: element.getAttribute('mp3player:file'),
			player: this,
			volume: 50,
			'autoPlay': element.getAttribute('mp3player:autoplay') == 'true',
			'autoLoad': element.getAttribute('mp3player:autoplay') == 'true',
			'onplay': function() {
				this.options.player.playButton.style.backgroundImage = 'url(/img/mp3_player/pause.png)';
			},
			'onfinish': function() {
				this.options.player.playButton.style.backgroundImage = 'url(/img/mp3_player/play.png)';
				this.options.player.slider.setValue(0);
			},
			'whileplaying': function(){
				this.options.player.durationEstimate = this.durationEstimate;
				
				if(!this.options.player.slider.dragging && !this.options.player.slider.active) {
					this.options.player.slider.setValue(this.position / this.durationEstimate);
				}
				this.options.player.progressTrack.setStyle({width: ((this.bytesLoaded/this.bytesTotal) * 167) + "px"});
			}
		});

		Event.observe(this.playButton, 'click', this.togglePause.bind(this));
	},
	
	togglePause: function() {
		this.playButton.style.backgroundImage = (this.playButton.style.backgroundImage == 'url(/img/mp3_player/pause.png)') ? 'url(/img/mp3_player/play.png)' : 'url(/img/mp3_player/pause.png)';
		soundManager.togglePause(this.soundManagerName);
	},
	
	update: function(value) {
		if((this.slider.active || this.newValue != null) && !this.slider.dragging) {
			this.newValue = this.newValue != null ? this.newValue : value * this.durationEstimate;
			soundManager.setPosition(this.soundManagerName,this.newValue);
			this.newValue = null;
		} else if(this.slider.dragging) {
			this.newValue = value * this.durationEstimate;
		}
	}
};
