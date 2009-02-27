<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup'
), false);
?>
<div class="gclms-content">
	<h1><?= __('Edit Student') ?></h1tud>    
		<?
		echo $form->create('Student',array('url' => $groupAndCoursePath . '/students/edit/' . $this->data['Student']['id']));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>