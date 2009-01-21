<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.2.1.1/tiny_mce',
	'gclms',
	'edit_article.js'
), false);

echo $this->element('no_column_background'); ?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath . '/articles' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Article') ?></h1>
		<?
		echo $form->create('Article',array('url' => $groupAndCoursePath . '/articles/edit/' . $this->data['Article']['id']));
		include('form.ctp');
		
		echo $this->element('save_and_delete',array(
			'confirm_delete_text' => __('Are you sure you want to delete this article?',true)
		));

		echo $form->end();
		?>
	</div>
</div>