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
		0 => __('Template; particiation specific to facilitated class', true),
		1 => __('Persistent; open to any user', true),
		2 => __('Persistent; open to associated facilitators', true)
	),
	array(
		'separator' => '<br />',
		'value' => isset($this->data['Forum']['type']) ? $this->data['Forum']['type'] : 0
	)
);