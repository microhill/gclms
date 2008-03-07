<div id="gclms-nodes-show-tree" class="gclms-expandable-list">
	<?
	$max_levels = 4;
		
	if(!isset($parent_node_id))
		$parent_node_id = 0;
	
	if(!isset($level))
		$level = 1;
	
	$root_node = array('id' => 0);
	
	$indexedNodes = array_combine(
		Set::extract($nodes, '{n}.Node.id'),
		Set::extract($nodes, '{n}.Node')
	);
	
	$nodes = sort_nodes($root_node,&$indexedNodes);
	
	function sort_nodes($parent_node,&$unsortedNodes) {
		$resultArray = array();
		$keys = array_keys($unsortedNodes);
		foreach($keys as $key) {
			if(!isset($unsortedNodes[$key]))
				continue;
			$node = $unsortedNodes[$key];
			if($node['parent_node_id'] == $parent_node['id']) {
				unset($unsortedNodes[$key]);
				$node['ChildNode'] = sort_nodes($node,$unsortedNodes);
				$resultArray[] = $node;
			}
			
		}
		return $resultArray;
	}
	
	function display_nodes($nodes,$level = 1,$groupAndCoursePath) {
		echo '<ul>';
		
		foreach($nodes as $node) {
			echo '<li class="';
			
			if(!empty($node['ChildNode'])) {
				if($level < 2)
					echo ' gclms-expanded';	
				else
					echo ' gclms-collapsed gclms-hidden';	
			} else
				echo ' gclms-empty';
			echo '">';
			echo '<img class="gclms-expand-button" src="/img/blank-1.png"/> ';
			if($node['type'] == 0)
				echo '<a href="' . $groupAndCoursePath . '/pages/view/' . $node['id'] . '">' . $node['title'] . '</a>';
			else
				echo $node['title'];
			if(!empty($node['ChildNode']))
				display_nodes($node['ChildNode'],$level + 1,$groupAndCoursePath);
			echo '</li>';	
		}
		
		echo '</ul>';
	}
	
	display_nodes($nodes,1,$groupAndCoursePath);
	?>
</div>