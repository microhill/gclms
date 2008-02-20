<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_group.js'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/groups"><? __('Cancel and go back') ?></a></div>
	<?= $this->renderElement('notifications'); ?>
	<h1><?= __('Add Group') ?></h1>    
		<?
		echo $form->create('Group', array('action' => 'add','type'=>'file'));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'Save'));
		echo $form->end();
		?>
	</div>
</div>