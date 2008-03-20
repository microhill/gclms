<?= $this->renderElement('no_column_background'); ?>

<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/glossary' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Glossary Term') ?></h1>    
		<?
		echo $form->create('GlossaryTerm',array('url' => $groupAndCoursePath . '/glossary/edit/' . $this->data['GlossaryTerm']['id']));
		include('form.ctp');
		echo '<div class="submit">';
		echo $form->submit(__('Save',true),array('class'=>'gclms-save','div'=>false));
		echo $form->submit(__('Delete',true),array('class'=>'gclms-delete','div'=>false,'gclms:confirm-text'=>__('Are you sure you want to delete this glossary term?',true)));
		echo '</div>';		
		echo $form->end();
		?>
	</div>
</div>