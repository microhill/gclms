<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'edit_dictionary'
), false);

echo $this->renderElement('no_column_background'); ?>

<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/dictionary' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Dictionary Term') ?></h1>    
		<?
		echo $form->create('DictionaryTerm',array('url' => $groupAndCoursePath . '/dictionary/edit/' . $this->data['DictionaryTerm']['id']));
		include('form.ctp');
		echo '<div class="submit">';
		echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
		echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this dictionary term?',true)));
		echo '</div>';		
		echo $form->end();
		?>
	</div>
</div>