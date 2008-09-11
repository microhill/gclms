<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'vendors/tinymce3.1.0.1/tiny_mce',
	'gclms',
	'edit_group'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><? __('Group Configuration') ?></h1>
	<?
	echo $form->create('Group',array(
		'type' => 'file',
		'url'=> $groupWebPath . '/configuration'
	));
	
	include(ROOT . DS . APP_DIR . DS . 'views' . DS . 'groups' . DS . 'form.ctp');
	
	echo $form->end('Save');
	?>
</div>