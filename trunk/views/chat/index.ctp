<?
$html->css('chat', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/uuid',
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
			<?
			$lastMessageAuthor = null;
			foreach($chat_messages as $chat_message): ?>
				<? if($lastMessageAuthor != $chat_message['User']['alias']): ?>
					<div class="gclms-chat-message-with-author-identity">
						<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($chat_message['User']['email']) ?>&default=<?= urlencode(@$default) ?>&size=40" />
						<span class="gclms-author"><?= $chat_message['User']['alias'] ?></span>:
				<? else: ?>
					<div class="gclms-chat-message">
				<? endif; ?>
						<span id="<?= $chat_message['ChatMessage']['id'] ?>" gclms:message-timestamp="<? $chat_message['ChatMessage']['created'] ?>"><?= $text->autoLinkUrls($chat_message['ChatMessage']['content']) ?></span>
					</div>
				<?
				$lastMessageAuthor = $chat_message['User']['alias'];
				?>
			<? endforeach; ?>
		</div>
		<div id="gclms-new-chat-message">
			<table>
				<tr>
					<td>
						<textarea id="gclms-chat-message-text"></textarea>
					</td>
					<td id="gclms-button-cell">
						<button id="gclms-send-message-button"><? __('Send message') ?></button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<?= $this->element('right_column'); ?>