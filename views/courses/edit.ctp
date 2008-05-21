<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.6/tiny_mce',
	'gclms',
	'edit_course'
), false);

echo $this->element('no_column_background'); ?>

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
	echo $form->submit(__('Save',true),array('class'=>'gclms-save','id'=>'CourseSave','div'=>false));
	echo $form->submit(__('Delete',true),array('class'=>'gclms-delete','id'=>'CourseDelete','div'=>false,'gclms:confirm-text'=>__('Are you sure you want to delete this course?',true)));
	echo '</div>';

	echo $form->end();
	?>
</div>