<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.8/tiny_mce',
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
	
	echo $this->element('save_button');
	echo $form->end();
	?>
</div>