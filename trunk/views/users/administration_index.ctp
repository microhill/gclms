<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><? __('Users') ?></h1>
		<button href="/administration/users/add"><? __('Add') ?></button>
		<? include('table.ctp'); ?>
	</div>
</div>

<?= $this->element('right_column'); ?>