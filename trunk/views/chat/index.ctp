<?
$html->css('chat', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/soundmanager2.77/soundmanager2-nodebug-jsmin',
	'vendors/uuid1.0',
	'gclms',
	'chat'
), false);

$secondary_column = $this->element('chat_participants');
?>
<?= $this->element('left_column',array(
		'secondary_column' => $secondary_column
	)); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<?
		if($chat_messages)		
			$latestDatetime = strtotime($chat_messages[sizeof($chat_messages) - 1]['ChatMessage']['created']);
		?>
		<div id="gclms-chat-messages" gclms:user-id="<?= $user['id'] ?>" gclms:user-username="<?= $user['username'] ?>" gclms:last-message-datetime="<?= isset($latestDatetime) ? $latestDatetime : time() ?>">
			<?
			$lastMessageAuthor = null;
			foreach($chat_messages as $chat_message): ?>
				<? if($lastMessageAuthor != $chat_message['User']['username']): ?>
					<div class="gclms-chat-message-with-author-identity">
						<img class="gclms-gravatar" src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($chat_message['User']['email']) ?>&default=<?= urlencode(Configure::read('App.domain') . 'img/icons/oxygen_refit/48x48/apps/user-info.png') ?>&size=48" />
						<span class="gclms-author"><?= $chat_message['User']['username'] ?></span>:
				<? else: ?>
					<div class="gclms-chat-message">
				<? endif; ?>
						<span id="<?= $chat_message['ChatMessage']['id'] ?>" gclms:message-timestamp="<? $chat_message['ChatMessage']['created'] ?>"><?= $text->autoLinkUrls($chat_message['ChatMessage']['content']) ?></span>
					</div>
				<?
				$lastMessageAuthor = $chat_message['User']['username'];
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

<?= $this->element('right_column',array(
		'secondary_column' => $secondary_column
	)); ?>