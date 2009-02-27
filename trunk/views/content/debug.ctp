<style>
.gclms-expandable-list li.gclms-collapsed > ul > li {
	display: block;
}
</style>
<div class="gclms-content">
	<h1><?= __('Debug') ?></h1> 
		<?
		if(!empty($nodes))
			echo $this->element('nodes_tree_debug',array(
				'nodes' => $nodes
			));
		?>
	</div>
</div>