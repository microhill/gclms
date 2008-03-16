<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/users"><? __('Cancel and go back') ?></a></div>
	<?= $this->renderElement('notifications'); ?>
	<h1><?= __('Edit User') ?></h1>    

	<?
	echo $form->create('User', array('url'=>'/administration/users/edit/' . $this->data['User']['id']));
	include('form.ctp');
	
	echo '<div>';
	echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false,'id'=>'UserSave'));
	echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'id'=>'UserDelete','gclms:confirm-text'=>__('Are you sure you sure you want to delete this user?',true)));
	echo '</div>';
	echo $form->end();
	?>
</div>