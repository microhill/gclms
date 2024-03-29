<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.2.1.1/tiny_mce',
	'gclms',
	'edit_chapter'
), false);

?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/chapters/toc/' . $this->data['Chapter']['book_id'] ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Edit Chapter') ?></h1>
	<?
	echo $form->create('Chapter',array('url'=> $groupAndCoursePath . '/chapters/edit/' . $this->data['Chapter']['id']));
	echo $form->hidden('book_id');

	echo $form->input('title',array(
		'label' =>  __('Title', true),
		'between' => '<br/>',
		'size' => 40
	));
	echo $form->input('content',array(
		'label' => __('Content',true),
		'between' => '<br/>',
		'rows' => 35,
		'cols' => 100
	));

	echo $this->element('save_and_delete',array(
		'confirm_delete_text' => __('Are you sure you want to delete this chapter?',true)
	));

	echo $form->end();
	?>
	</div>
</div>