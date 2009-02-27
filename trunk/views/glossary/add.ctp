<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.2.1.1/tiny_mce',
	'gclms',
	'popup',
	'edit_glossary'
), false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/glossary' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Glossary Term') ?></h1>    
		<?
		echo $form->create('GlossaryTerm',array('id' => null,'url'=> $groupAndCoursePath . '/glossary/add'));
		echo $form->hidden('course_id',array('value'=>$course['id']));
		include('form.ctp');

		echo $form->end('Save');
		?>
	</div>
</div>