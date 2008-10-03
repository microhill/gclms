<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/tinymce3.1.0.1/tiny_mce',
	'edit_class'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/classes' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Edit Class') ?></h1>
		<?
		echo $form->create('VirtualClass',array('id' => null,'url'=> $groupAndCoursePath . '/classes/edit/' . $this->data['VirtualClass']['id']));

		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>