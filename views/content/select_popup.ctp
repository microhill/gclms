<h2><? __('Select a Page') ?></h2>
<div class="gclms-content">
	<?
	if(!empty($nodes))
		echo $this->element('nodes_tree',array(
			'nodes' => $nodes
		));
	?>
</div>