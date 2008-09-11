<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);
?>

<?= $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<? include('table.ctp'); ?>
	</div>
</div>

<?= $this->element('right_column'); ?>