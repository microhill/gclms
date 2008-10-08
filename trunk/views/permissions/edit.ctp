<?
echo $this->element('no_column_background');

$html->css('permissions', null, null, false);
?>
<div class="gclms-content">
	<?= $this->element('notifications'); ?>
	<h1>
		<? __('Edit User Permissions') ?>
	</h1>

	<? include('form.ctp') ?>
</div>