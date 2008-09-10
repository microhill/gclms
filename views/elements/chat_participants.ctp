<h3><?= __('Who is here?') ?></h3>

<ul id="gclms-chat-participants">
	<? foreach($chat_participants as $chat_participant): ?>
		<?
		$gravatar_id = md5($chat_participant['User']['email']);
		?>
		<li id="<?= $chat_participant['User']['id'] ?>" gclms:gravatar-id="<?= $gravatar_id ?>">
			<img class="gclms-gravatar" src="http://www.gravatar.com/avatar.php?gravatar_id=<?= $gravatar_id ?>&size=48&default=<?= urlencode(Configure::read('App.domain') . 'img/icons/oxygen_refit/48x48/apps/user-info.png') ?>" /> <?= $chat_participant['User']['alias'] ?>
		</li>
	<? endforeach; ?>
</ul>

<div id="soundmanager-debug">
	
</div>