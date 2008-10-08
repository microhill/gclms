<?
echo $this->element('no_column_background');

$html->css('permissions', null, null, false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
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