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
		<h1><?= __('Administrators') ?></h1>
		<button href="administrators/add"><? __('Add') ?></button>
		<ul>
		<?
		foreach($this->data as $administrator) {
			?>
			<li><a href="administrators/edit/<?= $administrator['User']['id'] ?>"><?= $administrator['User']['username'] ?></a></li>
			<?
		}
		?>
		</ul>
	</div>
</div>

<?= $this->element('right_column'); ?>