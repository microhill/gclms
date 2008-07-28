<?
$html->css('books', null, null, false);
$html->css('/' . $group['web_path'] . '/files/css', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'books'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content gclms-chapter">	
        <div class="gclms-option-buttons">
            <a class="gclms-edit" href="<?= $groupAndCoursePath ?>/chapters/edit/<?= $this->data['Chapter']['id'] ?>" target="_top"><? __('Edit') ?></a>
        </div>
		<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>/<?= $course['web_path'] ?>/books"><? __('Back to Books') ?></a></div>
		<h1><?= $this->data['Chapter']['title'] ?></h1>
		<?= $this->data['Chapter']['content'] ?>
	</div>
</div>

<?= $this->element('right_column'); ?>