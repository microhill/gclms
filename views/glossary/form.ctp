<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.8/tiny_mce',
	'gclms',
	'edit_glossary'
), false);

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