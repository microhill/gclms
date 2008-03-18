<?
class NodeSorterHelper extends AppHelper {	
	function sort($nodes) {	
		$indexedNodes = array_combine(
			Set::extract($nodes, '{n}.Node.id'),
			Set::extract($nodes, '{n}.Node')
		);
		
		$parentChildRelationships = array_combine(
			Set::extract($nodes, '{n}.Node.id'),
			Set::extract($nodes, '{n}.Node.parent_node_id')
		);
		
		$this->indexedNodes = $indexedNodes;
		$this->parentChildRelationships = array_invert($parentChildRelationships);
		
		return $this->__sort();
	}

	function __sort($parentNodeId = 0) {
		$resultArray = array();
		
		foreach($this->parentChildRelationships[$parentNodeId] as $childId) {
			$node = $this->indexedNodes[$childId];
			if(!empty($this->parentChildRelationships[$childId]))
				$node['ChildNode'] = $this->__sort($childId);
			$resultArray[] = $node;			
		}
		
		return $resultArray;
	}
}