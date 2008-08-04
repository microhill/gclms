<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">	
	<h1><?= sprintf(__('Migrated %s', true), $file) ?></h1>
	<script>
	window.location.reload();
	</script>
</div>