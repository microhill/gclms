/*global gclms, $, $$, $F, Ajax, PeriodicalExecuter, document, Position, UUID, soundManager */

gclms.ChatController = {
	loadChatRoom: function() {
		$('gclms-chat-message-text').focus();
		var chatExecutor = new PeriodicalExecuter(gclms.ChatController.updateChatRoom, 6);
		gclms.ChatController.resizeChatroom();
		soundManager.onload = function() {
			soundManager.createSound('newMessage','/sounds/new-message.mp3');
		}
	},

	sendMessage: function(event) {	
		var content = $F('gclms-chat-message-text').stripTags().strip();
		if((event.keyCode != 13 && event.type != 'click') || content.blank()) {
			return false;
		}
		event.stop();

		$('gclms-chat-message-text').value = '';

		var id = UUID.generate();
	
        if ($('gclms-chat-messages').down('.gclms-chat-message-with-author-identity')) {
            var lastAuthor = $$('.gclms-chat-message-with-author-identity span.gclms-author').last().innerHTML;
        }
        else {
            var lastAuthor = null;
        }
		if (lastAuthor != $('gclms-chat-messages').getAttribute('gclms:user-alias')) {
			$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-new-author').interpolate({
				id: id,
				alias: $('gclms-chat-messages').getAttribute('gclms:user-alias'),
				gravatar_id: $($('gclms-chat-messages').getAttribute('gclms:user-id')).getAttribute('gclms:gravatar-id'),
				content: content
			})});
		} else {
			$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-same-author').interpolate({
				id: id,
				alias: $('gclms-chat-messages').getAttribute('gclms:user-alias'),
				content: content
			})});	
		}
		$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;

		gclms.ChatMessage.send({
			content: content,
			id: id
		});

		$('gclms-chat-message-text').focus();
	},
	
	
	leaveChatroom: function() {
		var request = new Ajax.Request(gclms.ChatMessage.ajaxUrl + 'leave/', {asynchronous:false})
	},
	
	resizeChatroom: function() {
		var newHeight = $('gclms-new-chat-message').cumulativeOffset().top - $('gclms-chat-messages').cumulativeOffset().top - 10;
		$('gclms-chat-messages').style.height = newHeight + 'px';
		$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;
	},
	
	updateChatRoom: function(executer) {
		executer.stop();
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
						$$('gclms-chat-participants li').each(function(li) {
							li.addClassName('gclms-to-be-removed');
						});
						
						if($(json.ChatParticipants[x].User.id)) {
							$(json.ChatParticipants[x].User.id).removeClassName('gclms-to-be-removed');
						} else {
							$('gclms-chat-participants').insert({bottom: gclms.Views.get('chat-participant').interpolate({
								id: json.ChatParticipants[x].User.id,
								alias: json.ChatParticipants[x].User.alias,
								gravatar_id: json.ChatParticipants[x].User.gravatar_id
							})});				
						}
						
						$$('gclms-chat-participants li.gclms-to-be-removed').each(function(li) {
							li.remove();
						});
					}
				}

				var id,lastAuthor,newMessageFromOtherAuthor = false;
				if(json.ChatMessages.length) {
					for(x = 0;x < json.ChatMessages.length;x++) {
						id = json.ChatMessages[x].ChatMessage.id;
						if($(id)) {
							$(id).innerHTML = json.ChatMessages[x].ChatMessage.content;
						} else {
					        newMessageFromOtherAuthor = true;
							if ($('gclms-chat-messages').down('.gclms-chat-message-with-author-identity')) {
					            var lastAuthor = $$('.gclms-chat-message-with-author-identity span.gclms-author').last().innerHTML;
					        }
					        else {
					            var lastAuthor = null;
					        }
							if(lastAuthor != json.ChatMessages[x].User.alias) {
								$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-new-author').interpolate({
									id: json.ChatMessages[x].ChatMessage.id,
									alias: json.ChatMessages[x].User.alias,
									gravatar_id: $(json.ChatMessages[x].User.id).getAttribute('gclms:gravatar-id'),
									content: json.ChatMessages[x].ChatMessage.content,
									timestamp: json.ChatMessages[x].ChatMessage.created
								})});
							} else {
								$('gclms-chat-messages').insert({bottom: gclms.Views.get('chat-message-same-author').interpolate({
									id: json.ChatMessages[x].ChatMessage.id,
									content: json.ChatMessages[x].ChatMessage.content,
									timestamp: json.ChatMessages[x].ChatMessage.created
								})});
							}
						}

						$('gclms-chat-messages').scrollTop = $('gclms-chat-messages').scrollHeight;
						var latestDatetime = json.ChatMessages[x].ChatMessage.created;
					}
					$('gclms-chat-messages').setAttribute('gclms:last-message-datetime',latestDatetime);
					if(newMessageFromOtherAuthor) {
						soundManager.play('newMessage');
					}
				}
			}
		});
		var chatExecutor = new PeriodicalExecuter(gclms.ChatController.updateChatRoom, 6);
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
	'#gclms-chat-messages': gclms.ChatController.loadChatRoom
});

//Because my 'triggers' prototype extension doesn't support window events yet...
Event.observe(window, 'resize', gclms.ChatController.resizeChatroom);

soundManager.url = '/js/vendors/soundmanager2.77/';

gclms.Views.update({
	'chat-participant': '<li id="#{id}" gclms:gravatar-id="#{gravatar_id}"><img class="gclms-gravatar" src="http://www.gravatar.com/avatar.php?gravatar_id=#{gravatar_id}&size=48" />  #{alias}</li>',
	'chat-message-same-author': '<div class="gclms-chat-message"><span id="#{id}" gclms:message-timestamp="#{timestamp}">#{content}</span></div>',
	'chat-message-new-author': '<div class="gclms-chat-message-with-author-identity"><img class="gclms-gravatar" src="http://www.gravatar.com/avatar.php?gravatar_id=#{gravatar_id}&default=&size=48" /> <span class="gclms-author">#{alias}</span>: <span id="#{id}" gclms:message-timestamp="#{timestamp}">#{content}</span></div>'
});