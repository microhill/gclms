<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions'
), false);

echo $this->element('no_column_background'); ?>

<div class="gclms-content">	
	<h1><?= __('Creating thumbnail...') ?></h1>
	<script>
	location.href = location.href + '?render';
	</script>
</div>