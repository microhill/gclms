<?
echo $form->input('term',array(
	'label' =>  __('Term', true),
	'between' => '<br/>',
	'size' => 40
));
echo $form->input('description',array(
	'label' => __('Description',true),
	'between' => '<br/>',
	'rows' => 25,
	'cols' => 100
));