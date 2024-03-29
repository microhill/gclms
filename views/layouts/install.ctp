<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<? include 'views/layouts/head.ctp'; ?>

<body class="gclms-install">
	<?= implode(order(array(
		$this->element('breadcrumbs')
	)),$text_direction); ?>
	
	<div id="gclms-page">
		<?= $content_for_layout ?>
	</div>
	<?
	$javascript->link('vendors/prototype1.6.0.3', false);
	$javascript->link('vendors/prototype_extensions1.0', false);
	$javascript->link('gclms', false);
	echo $asset->js_for_layout();
	?>
</body>
</html>