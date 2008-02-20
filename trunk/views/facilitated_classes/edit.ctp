<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<h1><?= __('Edit Facilitated Class') ?></h1>    
		<?
		echo $form->create('FacilitatedClass',array(
			'id' => null,
			'url'=> '/' . $groupWebPath . '/facilitated_classes/edit/' . $this->data['FacilitatedClass']['id']
		));
		include('form.ctp');

		echo '<div class="submit">';
		echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
		echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this?',true)));
		echo '</div>';

		echo $form->end();
		?>
	</div>
</div>