<?
$html->css('announcements', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

$this->element('../class/secondary_column');

$primary_column = $this->element('primary_column');
$secondary_column = $this->element('secondary_column');

echo $this->element('left_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));
?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><?= Course::get('title') ?> (<?= VirtualClass::get('title') ?>)</h1>
		<?
		if(!empty($nodes))
			echo $this->element('nodes_tree',array(
				'nodes' => $nodes,
				'here' => $this->here,
				'sibling_links' => false
			));
		?>
		
	</div>
</div>

<?= $this->element('right_column',array(
	'primary_column' => $primary_column,
	'secondary_column' => $secondary_column
));?>