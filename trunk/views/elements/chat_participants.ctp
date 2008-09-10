<h3><?= __('Who is here?') ?></h3>

<ul id="gclms-chat-participants">
	<? foreach($chat_participants as $chat_participant): ?>
		<?
		$gravatar_id = md5($chat_participant['User']['email']);
		?>
		<li id="<?= $chat_participant['User']['id'] ?>" gclms:gravatar-id="<?= $gravatar_id ?>">
			<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= $gravatar_id ?>&size=50" /> <?= $chat_participant['User']['alias'] ?>
		</li>
	<? endforeach; ?>
</ul>