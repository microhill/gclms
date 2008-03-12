<? echo $this->renderElement('left_column'); ?>
<div class="gclms-center-column">
	<div class="gclms-content article">
		<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/articles"><? __('All Articles') ?></a></div>
			<h1><?= $this->data['Article']['title'] ?></h1>
			<?= $this->data['Article']['content'] ?>
		</div>
	</div>
</div>