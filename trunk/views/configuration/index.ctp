<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.4/tiny_mce',
	'gclms',
	'edit_group'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>"><? __('Cancel and go back') ?></a></div>
	<?= $this->renderElement('notifications'); ?>
	<h1><?= __('Group Configuration') ?></h1>
	<?
	echo $form->create('Group',array(
		'type' => 'file',
		'url'=> $groupWebPath . '/configuration'
	));
	
	include(ROOT . DS . APP_DIR . DS . 'views' . DS . 'groups' . DS . 'form.ctp');
	
	echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
	echo $form->end();
	?>
</div>