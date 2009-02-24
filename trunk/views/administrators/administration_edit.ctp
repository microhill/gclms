<?
$html->css('administrators', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'administrators'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="/<?= Group::get('web_path') ?>/permissions"><? __('Cancel and go back') ?></a></div>
	
	<h1>
		<? __('Edit Administrator') ?>
	</h1>
	
	<?= $form->create('Permission',array('url' => $this->here )) ?>
	
	<?
	include('form.ctp')
	?>
	<?= $form->submit('Save',array(
		'class' => empty($this->data['User']) ? 'gclms-hidden' : '',
		'id' => 'gclms-save-button'
	)) ?>
	<?= $form->end() ?>
</div>