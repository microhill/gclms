<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'groups'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><? __('Groups') ?></h1>
		<button href="/administration/groups/add"><? __('Add') ?></button>
		<? include('table.ctp'); ?>
	</div>
</div>

<?= $this->element('right_column'); ?>