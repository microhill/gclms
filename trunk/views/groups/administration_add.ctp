<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_group.js'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/groups"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Group') ?></h1>    
		<?
		echo $form->create('Group', array('action' => 'add','type'=>'file'));
		include('form.ctp');
		echo $this->element('save_button');
		echo $form->end();
		?>
	</div>
</div>