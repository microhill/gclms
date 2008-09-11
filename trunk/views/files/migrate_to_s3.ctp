<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">	
	<h1><?= sprintf(__('Migrated %s', true), $file) ?></h1>
	<script>
	window.location.reload();
	</script>
</div>