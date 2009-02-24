<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'vendors/tinymce3.2.1.1/tiny_mce',
	'gclms',
	'edit_course'
), false);

?>
<div class="gclms-content gclms-add-course">
	<div class="gclms-step-back"><a href="/<?= Group::get('web_path') ?>"><? __('Cancel and go back') ?></a></div>
	<h1><?= __('Add Course') ?></h1>    
		<?
		echo $form->create('Course',array('url'=>'/' . Group::get('web_path') . '/courses/add'));
		echo $form->hidden('group_id',array('value' => Group::get('id')));
		include('form.ctp');
		echo $form->end('Save');
		?>
	</div>
</div>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script>
google.load('language', '1');
//google.setOnLoadCallback(submitChange);
</script>