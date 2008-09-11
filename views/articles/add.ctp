<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/tinymce3.1.0.1/tiny_mce',
	'edit_article.js'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/articles' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Article') ?></h1>
		<?
		echo $form->create('Article',array('id' => null,'url'=> $groupAndCoursePath . '/articles/add'));
		echo $form->hidden('course_id',array('value'=>$course['id']));
		include('form.ctp');

		echo $form->end('Save'); ?>
	</div>
</div>