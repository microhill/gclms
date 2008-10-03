<?
$javascript->link(array(
	'vendors/tinymce3.1.0.1/tiny_mce',
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'edit_group'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/groups"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Edit Group') ?></h1>    

	<?
	echo $form->create('Group', array(
		'url'=>'/administration/groups/edit/' . $this->data['Group']['id'],
		'type' => 'file'
	));
	include('form.ctp');

	echo $this->element('save_and_delete',array(
		'delete_url' => $groupAndCoursePath . '/administration/groups/delete/' . $this->data['Group']['id'],
		'confirm_delete_text' => __('Are you sure you want to delete this group?',true)
	));
	
	echo $form->end(); ?>
</div>