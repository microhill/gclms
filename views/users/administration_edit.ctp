<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup',
	'edit_user'
), false);

?>
<div class="gclms-content">
	<div class="gclms-step-back"><a href="/administration/users"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Edit User') ?></h1>    

	<?
	echo $form->create('User', array('url'=>'/administration/users/edit/' . $this->data['User']['id']));
	include('form.ctp');
	
	echo $this->element('save_and_delete',array(
		'confirm_delete_text' => __('Are you sure you want to delete this course?',true)
	));

	echo $form->end();
	?>
</div>