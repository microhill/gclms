<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.1.0.1/tiny_mce',
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