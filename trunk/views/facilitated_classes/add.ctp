<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('no_column_background');
?>

<div class="gclms-content">
	<h1><?= __('Add Facilitated Class') ?></h1>    
		<?
		echo $form->create('FacilitatedClass',array('url'=> '/' . $groupWebPath . '/facilitated_classes/add'));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'Save'));
		echo $form->end();
		?>
	</div>
</div>