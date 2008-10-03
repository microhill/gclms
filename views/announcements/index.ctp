<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column'); ?>
	
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><?= $course['title'] ?></h1>
		<?
		//pr($announcments);
		
		if(!empty($nodes))
			echo $this->element('nodes_tree',array(
				'nodes' => $nodes,
				'here' => $this->here,
				'sibling_links' => false
			));
		?>
		
	</div>
</div>

<?= $this->element('right_column'); ?>