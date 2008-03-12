<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/dictionary' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Dictionary Term') ?></h1>    
		<?
		echo $form->create('DictionaryTerm',array('id' => null,'url'=> $groupAndCoursePath . '/dictionary/add'));
		echo $form->hidden('course_id',array('value'=>$course['id']));
		include('form.ctp');
		echo $form->submit(__('Save',true),array('class'=>'Save'));
		echo $form->end();
		?>
	</div>
</div>