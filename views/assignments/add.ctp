<?
$html->css('edit_assignment', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/uuid1.0',
	'gclms',
	'popup',
	'edit_assignment.js'
), false);
?>
<div class="gclms-content">
	<h1><?= __('Add Assignment') ?></h1>    
		<?
		echo $form->create('Assignment',array('id' => null,'url' => $groupAndCoursePath . '/assignments/add'));
		echo $form->hidden('course_id',array('value'=>Course::get('id')));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
		echo $form->end();
		?>
	</div>
</div>