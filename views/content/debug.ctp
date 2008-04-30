<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content">
	<h1><?= __('Debug') ?></h1> 
		<?
		if(!empty($nodes))
			echo $this->renderElement('nodes_tree_debug',array(
				'nodes' => $nodes
			));
		?>
	</div>
</div>