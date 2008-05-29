<?
echo $this->element('buttons',array('buttons' => array(
	array(
		'text' => __('Save',true),
		'hover_color' => 'green',
		'class' => 'gclms-submit'
	),
	
	array(
		'text' => __('Delete',true),
		'hover_color' => 'red',
		'class' => 'gclms-delete',
		'phrases' => array(
			'gclms:confirm-text' => $confirm_delete_text
		)
	)
)));