<div class="gclms-content">
	<?
	if($chat_messages)		
		$latestDatetime = strtotime($chat_messages[sizeof($chat_messages) - 1]['ChatMessage']['created']);
	?>
	<div id="chatMessages" chat:myName="<?= $user['first_name'] . ' ' . $user['last_name'] ?>" ajax:latestDatetime = "<?= isset($latestDatetime) ? $latestDatetime : time() ?>" ajax:urlPrefix="/<?= $group['web_path'] ?>/chat/" ajax:urlSuffix="<?= '/section:' . $facilitated_class['id'] ?>">
		<?
		foreach($chat_messages as $chat_message) {
			echo '<div class="chatMessage"><span class="name">' . $chat_message['User']['first_name'] . ' ' . $chat_message['User']['last_name'] . ':</span> ' . $text->autoLinkUrls($chat_message['ChatMessage']['content']) . '</div>';
		}
		?>
	</div>
	<div id="newChatMessage">
	<?
	echo $form->input('ChatMessage.text',array('class'=>'text','label' => '','div'=>false,'ajax:url'=>'/' . $group['web_path'] . '/chat/send/section:' . $facilitated_class['id']));
	echo $form->submit(__('Send',true),array('class'=>'send','div'=>false,'id'=>'SendMessageButton'));	
	?>
	</div>
</div>

<script type="text/javascript" src="/js/<?= JS_FILE ?>"></script>