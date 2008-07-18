<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
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