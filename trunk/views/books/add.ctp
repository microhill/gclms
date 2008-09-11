<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms',
	'vendors/tinymce3.1.0.1/tiny_mce'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/books' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Book') ?></h1>
		<?
		echo $form->create('Book',array('id' => null,'url'=> $groupAndCoursePath . '/books/add'));
		echo $form->hidden('course_id',array('value'=>$course['id']));
		echo $form->input('title',array(
			'label' =>  __('Title', true),
			'between' => '<br/>',
			'size' => 40
		));

		echo $form->end('Save'); ?>
	</div>
</div>