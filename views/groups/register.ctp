<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<h1><?= __('Register Your Group') ?></h1>    
	<p>
		<? __("We're glad you have considered using Internet Biblical Seminary's learning platform for your ministry.") ?>
		<? __('We will review your submission, and you will be notified by email indicating whether your group has been accepted.') ?>
	</p>
	<?
	echo $form->create('Group', array('action' => 'register'));

	include(ROOT . DS . APP_DIR . DS . 'views' . DS . 'groups' . DS . 'form.ctp');

	echo $form->submit(__('Submit',true),array('class'=>'Save'));
	echo $form->end();
	?>
	</div>
</div>