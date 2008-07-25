<?
$html->css('/' . $group['web_path'] . '/files/css', null, null, false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content chapter">	
		<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/books"><? __('Back to Books') ?></a></div>
		<h1><?= $this->data['Chapter']['title'] ?></h1>
		<?= $this->data['Chapter']['content'] ?>
	</div>
</div>

<?= $this->element('right_column'); ?>