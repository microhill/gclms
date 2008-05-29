<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_group'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/groups"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Edit Group') ?></h1>    

	<?
	echo $form->create('Group', array(
		'url'=>'/administration/groups/edit/' . $this->data['Group']['id'],
		'type' => 'file'
	));
	include('form.ctp');
	echo $this->element('save_and_delete_buttons',array(
		'confirm_delete_text' => __('Are you sure you want to delete this article?',true)
	));
	echo $form->end();
	?>
</div>