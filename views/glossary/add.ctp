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