<?= $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><?= $course['title'] ?></h1>
		<h2><? __('Lessons') ?></h2>
		<?
		echo $this->element('lesson_listing',array(
			'lessons' => $lessons
		));
		?>

		<p>
			<?
			if(empty($virtual_class)) {
				App::import('Vendor','scripturizer'.DS.'scripturizer');
				$course['description'] = scripturize($course['description'],'NET');
				echo $course['description'];
			} else if(!empty($news_items)){
				echo $this->element('news_items');
			}
			?>
		</p>
		<? if(!empty($course['redistribution_allowed'])): ?>
			<p>
				<a href="<?= $license->getUrl($course['redistribution_allowed'],$course['commercial_use_allowed'],$course['derivative_works_allowed']) ?>"><img src="/img/somerights_en.png" width="88" height="31" /></a>
			</p>
		<? endif; ?>
	</div>
</div>

<?= $this->element('right_column'); ?>