<div class="notifications">
	<? foreach($notifications as $notification): ?>
	<div class="<?= $notification['type'] ?>">
		<?= $notification['text'] ?>
	</div>
	<? endforeach;?>
</div>