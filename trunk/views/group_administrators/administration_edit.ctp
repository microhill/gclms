<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_group_administrator'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/group_administrators"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Edit Group Administrator') ?></h1>    

	<?
	echo $form->create('GroupAdministrator', array('class' => 'Disabled','action'=>'edit'));
	echo $form->input('User.username',array(
		'label' =>  __('Username', true),
		'between' => '<br/>',
		'autocomplete' => 'off',
		'disabled' => 'disabled'
	));
	echo $form->input('GroupAdministrator.group_id',array(
		'label' =>  __('Group', true),
		'between' => '<br/>',
		'options' => $groups,
		'empty' => true,
		'selected' => @$data['GroupAdministrator']['group_id'],
		'disabled' => 'disabled'
	));

	echo $form->submit(__('Delete',true),array('class'=>'gclms-delete','gclms:confirm-text'=>__('Are you sure you want to delete this?',true)));
	echo $form->end();
	?>
</div>