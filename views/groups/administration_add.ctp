<?
$javascript->link(array(
	'vendors/tinymce3.1.0.1/tiny_mce',
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
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
		echo $form->end('Save');
		?>
	</div>
</div>