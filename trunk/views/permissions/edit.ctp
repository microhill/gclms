<?
echo $this->element('no_column_background');

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'permissions'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="/<?= $group['web_path'] ?>/permissions"><? __('Cancel and go back') ?></a></div>

	<h1>
		<? __('Edit User Permissions') ?>
	</h1>

	<?= $form->create('Permission',array('url' => $groupAndCoursePath . '/permissions/edit/' . $this->data['User']['id'])) ?>
	<? include('form.ctp') ?>
	<?= $form->submit('Save',array(
		'id' => 'gclms-save-button'
	)) ?>
	<?= $form->end() ?>
</div>