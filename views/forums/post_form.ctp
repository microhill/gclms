<?
echo $form->input('title',array(
	'label' =>  __('Title', true),
	'between' => '<br/>',
	'size' => 40
));
echo $form->input('content',array(
	'label' => __('Content',true),
	'between' => '<br/>',
	'rows' => 19,
	'cols' => 80
));