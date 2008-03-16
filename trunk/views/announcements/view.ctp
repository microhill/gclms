<div class="gclms-content">
	<h1><?= __('Add News Item') ?></h1>    
		<?
		echo $form->create('NewsItem',array('id' => null,'url'=> '/' . $groupWebPath . '/news/save/' . $this->data['NewsItem']['id'] . '/course:' . $courseWebPath . '/section:' . $facilitated_class['id']));
		echo $form->hidden('facilitated_class_id',array('value'=>$facilitated_class['id']));
		include('form.ctp');
		echo '<div class="submit">';
		echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
		echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'gclms:confirm-text'=>__('Are you sure you want to delete this news item?',true)));
		echo '</div>';		
		echo $form->end();
		?>
	</div>
</div>