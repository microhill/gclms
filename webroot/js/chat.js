ChatRules = {
	'#ChatMessageText:keydown, #SendMessageButton:click' : function(element,event) {
		if((event.keyCode != 13 && event.type != 'click') || !$F('ChatMessageText'))
			return false;
		chatMessageText = $F('ChatMessageText');
		$('ChatMessageText').value = '';

		new Ajax.Request($('ChatMessageText').getAttribute('ajax:url'), {
			method:'post',
			parameters:{'data[content]':chatMessageText},
			onComplete:function(request){
			}
		})
		new Insertion.Bottom($('chatMessages'),'<div class="chatMessage"><span class="name">' + $('chatMessages').getAttribute('chat:myName') + ':</span> ' + chatMessageText + '</div>');

		$('chatMessages').scrollTop = $('chatMessages').scrollHeight;
		Field.focus('ChatMessageText');
		Event.stop(event);
		Field.focus('ChatMessageText');
	},

	'window:unload' : function() {
		urlPrefix = $('chatMessages').getAttribute('ajax:urlPrefix');
		urlSuffix = $('chatMessages').getAttribute('ajax:urlSuffix');
		new Ajax.Request(urlPrefix + 'leave/' + urlSuffix, {asynchronous:false})
	}
}

if(document.body.getAttribute('gclms:controller') == 'Chat') {
	GCLMS.Triggers.update(ChatRules);
	if($('chatMessages')) {
		new PeriodicalExecuter(updateChatRoom, 6);
		$('chatMessages').scrollTop = $('chatMessages').scrollHeight;
	}
}

function updateChatRoom() {
	urlPrefix = $('chatMessages').getAttribute('ajax:urlPrefix');
	urlSuffix = $('chatMessages').getAttribute('ajax:urlSuffix');
	latestDatetime = $('chatMessages').getAttribute('ajax:latestDatetime');

	new Ajax.Request(urlPrefix + 'get/' + latestDatetime + urlSuffix, {
		onComplete:function(request,chatData){
			if(chatData.ChatParticipants.length) {
				newHTML = '';
				for(x = 0;x < chatData.ChatParticipants.length;x++) {
					newHTML += '<div>' + chatData.ChatParticipants[x].User.first_name + ' ' + chatData.ChatParticipants[x].User.last_name + '</div>';
				}
				if($('chatParticipants'))
					$('chatParticipants').innerHTML = newHTML;
			}

			if(chatData.ChatMessages.length) {
				for(x = 0;x < chatData.ChatMessages.length;x++) {

					new Insertion.Bottom($('chatMessages'),'<div class="chatMessage"><span class="name">' + chatData.ChatMessages[x].User.first_name + ' ' + chatData.ChatMessages[x].User.last_name + ':</span> ' + chatData.ChatMessages[x].ChatMessage.content + '</div>');

					$('chatMessages').scrollTop = $('chatMessages').scrollHeight;
					latestDatetime = chatData.ChatMessages[x].ChatMessage.created;
				}
				$('chatMessages').setAttribute('ajax:latestDatetime',latestDatetime);
			}
		}
	})
}

function resizeChatroom() {
	newHeight = document.documentElement.clientHeight - Position.cumulativeOffset($('chatMessages'))[1] - $('newChatMessage').getDimensions().height - 14;
	$('chatMessages').style.height = newHeight + 'px';
	$('ChatMessageText').style.width = ($('chatMessages').getDimensions().width - $('SendMessageButton').getDimensions().width) - 6 + 'px';
}