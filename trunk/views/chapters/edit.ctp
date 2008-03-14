<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.5/tiny_mce',
	'gclms',
	'edit_chapter'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
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

	echo '<div class="submit">';
	echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
	echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this chapter?',true)));
	echo '</div>';
	echo $form->end();
	?>
	</div>
</div>