/*global gclms, $, $F, Ajax, PeriodicalExecuter, document, Position */

gclms.ChatController = {
	sendMessage: function(event) {	
		var chatMessageText = $F('gclms-chat-message-text').stripTags().strip();
		if((event.keyCode != 13 && event.type != 'click') || chatMessageText.blank()) {
			return false;
		}
		event.stop();

		$('gclms-chat-message-text').value = '';

		var id = UUID.generate();
		$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-same-author').interpolate({
			alias: $('gclms-chat-messages').getAttribute('gclms:user-alias'),
			content: chatMessageText,
			id: id
		})});

		gclms.ChatMessage.send({
			content: chatMessageText,
			id: id
		});

		$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;
		$('gclms-chat-message-text').focus();		
	},
	
	
	leaveChatroom: function() {
		//var request = new Ajax.Request(urlPrefix + 'leave/', {asynchronous:false})
	},
	
	resizeChatroom: function() {
		var newHeight = document.documentElement.clientHeight - Position.cumulativeOffset($('gclms-chat-messages'))[1] - $('gclms-new-chat-message').getDimensions().height - 14;
		$('gclms-chat-messages').style.height = newHeight + 'px';
		$('gclms-chat-message-text').style.width = ($('gclms-chat-messages').getDimensions().width - $('gclms-send-message-button').getDimensions().width) - 6 + 'px';
	},
	
	updateChatRoom: function() {
		var latestDatetime = $('gclms-chat-messages').getAttribute('gclms:last-message-datetime');
		gclms.ChatMessage.get({
			latestDatetime: latestDatetime,
			callback: function(transport,json) {
				//I'm not sure why this works, but without it Firefox throws an error upon page load
				try {
					if(!json) {
						return false;
					}	
				} catch(e) {
					return false;
				}				

				if(json.ChatParticipants.length) {
					var newHTML = '';
					for(var x = 0;x < json.ChatParticipants.length;x++) {
						newHTML += gclms.Views.get('chat-participant').interpolate({
							id: json.ChatParticipants[x].User.id,
							alias: json.ChatParticipants[x].User.alias,
							gravatar_id: json.ChatParticipants[x].User.gravatar_id
						});
					}
					$('gclms-chat-participants').innerHTML = newHTML;
				}
				//alert(json.ChatMessages.length);
				var id;
				if(json.ChatMessages.length) {
					for(x = 0;x < json.ChatMessages.length;x++) {
						id = json.ChatMessages[x].ChatMessage.id;
						if($(id)) {
							$(id).innerHTML = json.ChatMessages[x].ChatMessage.content;
						} else {
							$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-same-author').interpolate({
								id: json.ChatMessages[x].ChatMessage.id,
								content: json.ChatMessages[x].ChatMessage.content,
								timestamp: json.ChatMessages[x].ChatMessage.created
							})});							
						}

						$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;
						var latestDatetime = json.ChatMessages[x].ChatMessage.created;
					}
					$('gclms-chat-messages').setAttribute('gclms:last-message-datetime',latestDatetime);
				}
			}
		});
	},
	
	loadChatRoom: function() {
		var chatExecutor = new PeriodicalExecuter(gclms.ChatController.updateChatRoom, 6);
		$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;
	},
	
	addOddRowClass: function() {
		this.addClassName('gclms-odd');
	},
	
	addEvenRowClass: function() {
		this.addClassName('gclms-even');
	}
};

gclms.ChatMessage = {
	ajaxUrl: gclms.urlPrefix + 'chat/',
	get: function(options) {
		var request = new Ajax.Request(gclms.urlPrefix + 'chat/get.json',{
			method: 'post',
			parameters: {
				'data[latest_datetime]': options.latestDatetime
			},
			onComplete: options.callback
		});
	},
	send: function(options) {
		var request = new Ajax.Request(gclms.urlPrefix + 'chat/send.json',{
			method: 'post',
			parameters: {
				'data[ChatMessage][id]': options.id,
				'data[ChatMessage][content]': options.content
			},
			onComplete: options.callback
		});
	}
};

gclms.Triggers.update({
	'#gclms-chat-message-text:keydown, #gclms-send-message-button:click': gclms.ChatController.sendMessage,
	//'window:unload': gclms.ChatController.leaveChatroom,
	'#gclms-chat-messages': gclms.ChatController.loadChatRoom,
	'table': {
		'#gclms-chat-messages tr:nth-child(odd)': gclms.ChatController.addOddRowClass,
		'#gclms-chat-messages tr:nth-child(even)': gclms.ChatController.addEvenRowClass	
	}
});

gclms.Views.update({
	'chat-participant': '<li id="#{id}"><img src="http://www.gravatar.com/avatar.php?gravatar_id=#{gravatar_id}&size=50" />  #{alias}</li>',
	'chat-message-same-author': '<div class="gclms-chat-message"><span id="#{id}" gclms:message-timestamp="#{timestamp}">#{content}</span></div>',
	'chat-message-new-author': '<div class="gclms-chat-message-with-author-identity"><img src="http://www.gravatar.com/avatar.php?gravatar_id=#{gravatar_id}&default=&size=40" /> <span class="gclms-author">#{alias}</span>: <span id="#{id}" gclms:message-timestamp="#{timestamp}">#{content}</span></div>'
});