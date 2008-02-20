<?
$flag = false;

echo '<ul id="' . String::uuid(). '">';

foreach($nodes as $key => $node) {
	if($node['Node']['parent_node_id'] == $parent_node_id) {
		unset($nodes[$key]);
		if($level < 4) {
			$childrenNodes = $this->renderElement('nodes_list',array(
				'nodes' => $nodes,
				'parent_node_id' => $node['Node']['id'],
				'level' => $level + 1
			));
		} else {
			$childrenNodes = '<ul id="' . String::uuid(). '"></ul>';
		}
		
		?>
		<li
				id="node_<?= $node['Node']['id'] ?>"
				gclms:node-id="<?= $node['Node']['id']; ?>"
				class="gclms-node <?
			echo $node['Node']['type'] ? 'gclms-label' : 'gclms-page'; 
			if(ereg('</li>',$childrenNodes)) {
				if($level < 1)
					echo ' gclms-expanded';	
				else
					echo ' gclms-collapsed gclms-hidden';	
			} else
				echo ' gclms-empty';
			?>">
			<img class="gclms-expand-button" src="/img/blank-1.png"/>
			<span class="gclms-handle">
				<img class="gclms-icon" src="/img/blank-1.png"/>
				<a href="#"><?= $node['Node']['title'] ?></a>
			</span>
			<?= $childrenNodes; ?>
		</li>
		<?
	}
}

echo '</ul>';