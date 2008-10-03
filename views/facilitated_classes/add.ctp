<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('no_column_background');
?>

<div class="gclms-content">
	<h1><?= __('Add Facilitated Class') ?></h1>    
		<?
		echo $form->create('FacilitatedClass',array('url'=> '/' . $groupWebPath . '/virtual_classes/add'));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>