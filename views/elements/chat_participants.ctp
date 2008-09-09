<div id="gclms-chat-participants">
	<?
	foreach($chat_participants as $chat_participant) {
		echo '<div>' . $chat_participant['User']['alias'] . '</div>';
	}
	?>
</div>

<p>
	<button id="gclms-upload-file">Upload File</button>
</p>