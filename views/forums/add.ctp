<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

?>

<div class="gclms-content">
	<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/forums"><? __('Cancel and go back') ?></a></div>
	<?= $this->element('notifications'); ?>
	<h1><?= __('Add Forum') ?></h1>    
	<?
	echo $form->create('Forum', array('url'=>$groupAndCoursePath . '/forums/add' . $framed_suffix));
	include('form.ctp');
	echo $form->submit(__('Save',true),array('class'=>'gclms-save'));
	echo $form->end();
	?>
</div>