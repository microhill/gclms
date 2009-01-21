<?
$html->css('notebook', null, null, false);

$javascript->link(array(
	'vendors/tinymce3.2.1.1/tiny_mce',
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/uuid1.0',
	'notebook'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<div class="gclms-step-back"><a href="/notebook"><? __('Notebook') ?></a></div>
		<h1><?= __('Add Notebook Entry') ?></h1>
		
		<?
		echo $form->create();
		include 'form.ctp';
		?>

		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Save',true),
				'hover_color' => 'green',
				'class' => 'gclms-submit'
			)
		)));
		echo $form->end();
		?>
	</div>
</div><?= $this->element('right_column'); ?>