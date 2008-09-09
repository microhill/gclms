<?
$html->css('chat', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'chat'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<?
		if($chat_messages)		
			$latestDatetime = strtotime($chat_messages[sizeof($chat_messages) - 1]['ChatMessage']['created']);
		?>
		<div id="gclms-chat-messages" gclms:user-alias="<?= $user['alias'] ?>" gclms:last-message-datetime="<?= isset($latestDatetime) ? $latestDatetime : time() ?>">
			<? foreach($chat_messages as $chat_message): ?>
				<div class="gclms-chat-message">
					<span class="gclms-name"><?= $chat_message['User']['alias'] ?>:</span>
					<?= $text->autoLinkUrls($chat_message['ChatMessage']['content']) ?>
				</div>
			<? endforeach; ?>
		</div>
		<table id="gclms-new-chat-message">
			<tr>
				<td><input type="text" id="gclms-chat-message-text" /></td>
				<td><button id="gclms-send-message-button" class="gclms-send"><? __('Send') ?></button></td>
			</tr>
		</table>
	</div>
</div>

<?= $this->element('right_column'); ?>