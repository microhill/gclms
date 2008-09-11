<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions',
	'gclms',
	'edit_group_administrator'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
	<h1><?= __('Add Group Administrator') ?></h1>    
		<?
		echo $form->create('GroupAdministrator', array('action' => 'add'));
		echo $form->input('email',array(
			'label' =>  __('Email', true),
			'between' => '<br/>',
			'autocomplete' => 'off'
		));
		//echo $form->hidden('user_id');
		echo $form->input('GroupAdministrator.group_id',array(
			'label' =>  __('Group', true),
			'between' => '<br/>',
			'options' => $groups,
			'empty' => true,
			'selected' => @$data['GroupAdministrator']['group_id']
		));
		
		echo $form->end('Save');
		?>
	</div>
</div>