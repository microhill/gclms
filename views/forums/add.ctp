<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums<?= $framed_suffix ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Forum') ?></h1>    
	<?
	echo $form->create('Forum', array('url'=>$groupAndCoursePath . '/forums/add' . $framed_suffix));
	include('form.ctp');
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>