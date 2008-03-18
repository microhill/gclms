<?
if(!empty($nodes))
	display_nodes($nodeSorter->sort($nodes),1,$groupAndCoursePath);

function display_nodes($nodes,$level = 1,$groupAndCoursePath) {
	if($level > 4) {
		return false;
	}
	
	echo '<ul id="' . String::uuid() . '">';
	
	foreach($nodes as $node) {
		echo '<li id="node_' . $node['id'] . '" gclms:node-id="' . $node['id'] . '" class="gclms-node';			 
		
		if(!empty($node['ChildNode'])) {
			if($level < 2)
				echo ' gclms-expanded';	
			else
				echo ' gclms-collapsed gclms-hidden';	
		} else {
			echo ' gclms-empty';
		}
		
		echo $node['type'] ? ' gclms-label' : ' gclms-page'; 
		echo '">';

		echo '<img class="gclms-expand-button" src="/img/blank-1.png" alt="Icon" /> ';
		echo '<span class="gclms-handle">';
			echo '<img class="gclms-icon" src="/img/blank-1.png" alt="Icon" />';
		
		echo ' <a href="' . $groupAndCoursePath . '/pages/edit/' . $node['id'] . '">' . $node['title'] . '</a>';
			
		echo '</span>';
			
		if(!empty($node['ChildNode']))
			display_nodes($node['ChildNode'],$level + 1,$groupAndCoursePath);
		else
			echo '<ul id="' . String::uuid() . '"></ul>';
			
		echo "</li>\n";
	}
	
	echo '</ul>';
}