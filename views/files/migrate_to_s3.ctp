<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">	
	<h1><?= sprintf(__('Migrated %s', true), $file) ?></h1>
	<script>
	window.location.reload();
	</script>
</div>