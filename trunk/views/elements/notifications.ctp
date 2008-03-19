<div class="gclms-notifications">
	<? foreach($notifications as $notification): ?>
	<div class="gclms-<?= $notification['type'] ?>">
		<?= $notification['text'] ?>
	</div>
	<? endforeach;?>
</div>