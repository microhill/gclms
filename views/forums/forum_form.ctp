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
		0 => __('This forum is created for each classroom', true),
		1 => __('This is a persistent forum open to any user', true),
		2 => __('Only associated facilitators can view this forum', true)
	),
	array(
		'separator' => '<br />'
	)
);