<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_course'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Configure Course') ?></h1>
	<?
	echo $form->create('Course',array(
		'id' => 'Course',
		'url' => $groupAndCoursePath . '/configuration',
		'gclms:deleteAction' => $groupAndCoursePath . '/configuration/delete'
		));

	echo $form->hidden('group_id');
	include('form.ctp');

	echo '<div class="submit">';
	echo $form->submit(__('Save',true),array('class'=>'Save','id'=>'CourseSave','div'=>false));
	echo $form->submit(__('Delete',true),array('class'=>'delete','id'=>'CourseDelete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this course?',true)));
	echo '</div>';

	echo $form->end();
	?>
</div>