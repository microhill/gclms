<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/tinymce3.2.1.1/tiny_mce',
	'edit_site_page'
), false);

?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<div class="gclms-step-back"><a href="<?= '/administration/site_pages' ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Site Page') ?></h1>
		<?
		echo $form->create('SitePage',array('id' => null,'url'=> '/administration/site_pages/add'));
		include('form.ctp');
		echo $form->end(__('Save',true));
		?>
	</div>
</div>