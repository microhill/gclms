<div id="gclms-nodes-tree" class="gclms-expandable-list gclms-nodes-tree">
	<?
	$max_levels = 4;
		
	if(!isset($parent_node_id))
		$parent_node_id = 0;
	
	if(!isset($level))
		$level = 1;
	
	function display_nodes($nodes,$level = 1,$groupAndCoursePath) {
		echo '<ul>';
		
		foreach($nodes as $node) {
			echo '<li gclms:node-id="' . $node['id'] . '" class="';			 
			
			if(!empty($node['ChildNode'])) {
				if($level < 2)
					echo ' gclms-expanded';	
				else
					echo ' gclms-collapsed gclms-hidden';	
			} else
				echo ' gclms-empty';
			echo '">';
			echo '<img class="gclms-expand-button" src="/img/blank-1.png" alt="Icon" /> ';
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