<?
echo $this->element('no_column_background');

$html->css('permissions', null, null, false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1>
		Edit permissions for %
	</h1>
	
	<? include('form.ctp') ?>
</div>