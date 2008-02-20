<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);
?>

<?= $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<? include('table.ctp'); ?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>