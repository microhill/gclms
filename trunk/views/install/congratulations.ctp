<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-center-column">
		<h1><? __('Congratulations!') ?></h1>
		<p><? __('You are ready to begin using Great Commission LMS. You will now be redirected to the front page.') ?></p>
		<script>
		setTimeout("self.location = '/';",5000);
		</script>
	</div>
</div>