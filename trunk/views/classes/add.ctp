<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/tinymce3.0.6/tiny_mce',
	'edit_class'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/classes' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Class') ?></h1>
		<?
		echo $form->create('VirtualClass',array('id' => null,'url'=> $groupAndCoursePath . '/classes/add'));

		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>