<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms',
	'edit_user'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/users"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add User') ?></h1>    
	<?
	echo $form->create('User', array('url'=>'/administration/users/add'));
	include('form.ctp');
	echo $form->end('Save');
	?>
</div>