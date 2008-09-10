<h3><?= __('Who is here?') ?></h3>

<ul id="gclms-chat-participants">
	<? foreach($chat_participants as $chat_participant): ?>
		<li><img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($chat_participant['User']['email']) ?>&size=50" /> <?= $chat_participant['User']['alias'] ?></li>
	<? endforeach; ?>
</ul>

<h3>Recently uploaded files</h3>

<p>
	<em>None</em>
</p>

<p>
	<button id="gclms-upload-file">Upload File</button>
</p>