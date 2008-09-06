<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/discussion ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Forum') ?></h1>    
	<?
	echo $form->create('Forum', array('url'=>$groupAndCoursePath . '/discussion/add_forum'));
	include('forum_form.ctp');
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>