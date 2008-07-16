<div id="gclms-nodes-tree" class="gclms-expandable-list gclms-nodes-tree">
	<?
	$max_levels = 4;
		
	if(!isset($parent_node_id))
		$parent_node_id = 0;
	
	if(!isset($level))
		$level = 1;

	function display_nodes($nodes,$level = 1,$groupAndCoursePath,$here,$offline) {
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
			$imgUrl = relativize_url($here,'/img/blank-1.png');
			echo '<img class="gclms-expand-button" src="' . $imgUrl . '" alt="Icon" /> ';

			if($offline)
				$extension = '.html';
			else
				$extension = '';	

			//$url = relativize_url($here,$groupAndCoursePath . '/pages/view/' . $node['id'] . $extension);
			$url = $groupAndCoursePath . '/pages/view/' . $node['id'] . $extension;

			//pr($here);
			//pr($groupAndCoursePath . '/pages/view/' . $node['id'] . $extension);
			//pr($url);die;

			if($node['type'] == 0)
				echo '<a href="' . $url . '">' . $node['title'] . '</a>';
			else
				echo $node['title'];
			if(!empty($node['ChildNode']))
				display_nodes($node['ChildNode'],$level + 1,$groupAndCoursePath,$here,$offline);
			echo '</li>';	
		}
		
		echo '</ul>';
	}

	if(!isset($here))
		$here = $this->here;
		
	display_nodes($nodes,1,$groupAndCoursePath,$here,$offline);
	?>
</div>