<div class="gclms-notifications">
	<? foreach($notifications as $notification): ?>
	<div class="gclms-<?= $notification['type'] ?><?= empty($notification['class']) ? '' : ' ' . $notification['class'] ?>">
		<?= $notification['text'] ?>
	</div>
	<? endforeach;?>
</div>