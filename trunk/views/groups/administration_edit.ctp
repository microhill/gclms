<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_group'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/groups"><? __('Cancel and go back') ?></a></div>
	<?= $this->renderElement('notifications'); ?>
	<h1><?= __('Edit Group') ?></h1>    

	<?
	echo $form->create('Group', array(
		'url'=>'/administration/groups/edit/' . $this->data['Group']['id'],
		'type' => 'file'
	));
	include('form.ctp');
	echo '<div>';
	echo $form->submit(__('Save',true),array('class'=>'save','div'=>false,'id' => 'GroupSave'));
	echo $form->submit(__('Delete',true),array('class'=>'gclms-delete','div'=>false,'id' => 'GroupDelete','gclms:confirm-text'=>__('Are you sure you sure you want to delete this?',true)));
	echo '</div>';
	echo $form->end();
	?>
</div>