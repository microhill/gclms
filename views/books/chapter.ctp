<?
$html->css('/' . Group::get('web_path') . '/files/css', null, null, false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content chapter">	
		<div class="gclms-step-back"><a href="/<?= Group::get('web_path') ?>/<?= $course['web_path'] ?>/books/panel"><? __('Back to Books') ?></a></div>
		<h1><?= $chapter['Chapter']['title'] ?></h1>
		<?= $chapter['Chapter']['content'] ?>
	</div>
</div>

<?= $this->element('right_column'); ?>