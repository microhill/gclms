<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'popup'
), false);
?>
<div class="gclms-content">
	<h1><?= __('Add Student') ?></h1>    
		<?
		echo $form->create('Student',array('id' => null,'url' => $groupAndCoursePath . '/students/add'));
		echo $form->input('identifier',array(
			'label' =>  __('Username or e-mail', true),
			'between' => '<br/>',
			'size' => 40
		));
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>