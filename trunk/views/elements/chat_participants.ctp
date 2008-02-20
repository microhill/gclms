<div id="chatParticipants">
	<?
	foreach($chat_participants as $chat_participant) {
		echo '<div>' . $chat_participant['User']['first_name'] . ' ' . $chat_participant['User']['last_name'] . '</div>';
	}
	?>
</div>