<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.4/tiny_mce',
	'gclms',
	'edit_course'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Course') ?></h1>    
		<?
		echo $form->create('Course',array('url'=>'/' . $group['web_path'] . '/courses/add'));
		echo $form->hidden('group_id',array('value' => $group['id']));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'Save'));
		echo $form->end();
		?>
	</div>
</div>