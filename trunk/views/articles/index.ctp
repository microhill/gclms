<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content">	
		<?= $this->renderElement('notifications'); ?>
		<? include('table.ctp'); ?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>