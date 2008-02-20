<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce/tiny_mce',
	'gclms',
	'edit_article.js'
), false);

echo $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->renderElement('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/articles' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Article') ?></h1>
		<?
		echo $form->create('Article',array('url' => $groupAndCoursePath . '/articles/edit/' . $this->data['Article']['id']));
		include('form.ctp');
		echo '<div class="submit">';
		echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
		echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this article?',true)));
		echo '</div>';
		echo $form->end();
		?>
	</div>
</div>