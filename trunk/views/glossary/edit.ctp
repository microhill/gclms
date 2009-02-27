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
		echo $form->create('GlossaryTerm',array('url' => $groupAndCoursePath . '/glossary/edit/' . $this->data['GlossaryTerm']['id']));
		include('form.ctp');
		
		echo $this->element('save_and_delete',array(
			'confirm_delete_text' => __('Are you sure you want to delete this glossary term?',true)
		));

		echo $form->end();
		?>
	</div>
</div>