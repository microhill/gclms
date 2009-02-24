<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0'
), false);

?>

<div class="gclms-content">	
	<h1><?= sprintf(__('Migrated %s', true), $file) ?></h1>
	<script>
	window.location.reload();
	</script>
</div>