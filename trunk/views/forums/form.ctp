<?
echo $form->input('title',array(
	'label' =>  __('Title', true),
	'between' => '<br/>'
));

echo $form->input('description',array(
	'label' =>  __('Description', true),
	'between' => '<br/>'
));

echo $form->radio('type',
	array(
		0 => __('Template for classes', true),
		1 => __('Open to any user who has been enrolled in course', true), 
		2 => __('Open to facilitators associated with course', true),
		3 => __('Publicly viewable and open to any verified user', true)
	),
	array(
		'separator' => '<br />',
		'value' => isset($this->data['Forum']['type']) ? $this->data['Forum']['type'] : 0
	)
);