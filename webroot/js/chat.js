/*global gclms, $, $F, Ajax, PeriodicalExecuter, document, Position */

gclms.ChatController = {
	sendMessage: function(event) {	
		var chatMessageText = $F('gclms-chat-message-text');
		if((event.keyCode != 13 && event.type != 'click') || !chatMessageText) {
			return false;
		}
		event.stop();

		$('gclms-chat-message-text').value = '';

		gclms.ChatMessage.send({
			content: chatMessageText
		});

		$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message').interpolate({
			alias: $('gclms-chat-messages').getAttribute('gclms:user-alias'),
			content: chatMessageText
		})});

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
				try {
					if(!json || !json.ChatMessages) {
						return false;
					}	
				} catch(e) {
					return false;
				}

				if(json.ChatParticipants.length) {
					var newHTML = '';
					for(var x = 0;x < json.ChatParticipants.length;x++) {
						newHTML += gclms.Views.get('chat-participant').interpolate({
							alias: json.ChatMessages[x].User.alias,
							content: json.ChatMessages[x].ChatMessage.content
						});
					}
					$('gclms-chat-participants').replace(newHTML);
				}
	
				if(json.ChatMessages.length) {
					for(x = 0;x < json.ChatMessages.length;x++) {
						$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message').interpolate({
							alias: json.ChatMessages[x].User.alias,
							content: json.ChatMessages[x].ChatMessage.content
						})});
	
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
				'data[ChatMessage][content]': options.content
			},
			onComplete: options.callback
		});
	},
};

gclms.Triggers.update({
	'#gclms-chat-message-text:keydown, #gclms-send-message-button:click': gclms.ChatController.sendMessage,
	//'window:unload': gclms.ChatController.leaveChatroom,
	'#gclms-chat-messages': gclms.ChatController.loadChatRoom
});

gclms.Views.update({
	'chat-participant': '<div id="#{id}">#{alias}</div>',
	'chat-message': '<div class="gclms-chat-message"><span class="gclms-name">#{alias}:</span> #{content}</div>'
});