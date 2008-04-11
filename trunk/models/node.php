<?
/*
 * Node type: 0 - page, 1 - label
 */
class Node extends AppModel {
    var $recursive = 0;

	var $belongsTo = array(
		'ParentNode' => array(
			'className' => 'Node',
			'foreignKey' => 'parent_node_id',
			'fields' => array('id')
		),
		'Course'
	);

	var $hasMany = array(
		'Textarea',
		'Question',
		'ChildNode' => array(
			'className' => 'Node',
			'foreignKey' => 'parent_node_id',
			//'fields' => array('id')
		)
	);

	function add($node) {
		$this->id = null;
		$node['Node']['order'] = $this->getLastOrderInParentNode($node['Node']['course_id'],$node['Node']['parent_node_id']) + 1;
		$this->save($node);

		return $this->id;
	}
	
	function getLastOrderInParentNode($courseId,$parentNodeId) {
		$order = $this->field('order',array('Node.course_id' => $courseId, 'Node.parent_node_id' => $parentNodeId),'Node.order DESC');
		return $order === false ? -1 : $order;
	}
	
	// Finds previous node of type page; recursive
	function findPreviousPageId($node) {
		if($node['Node']['order'] > 0) {
			$immediatePreviousNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => $node['Node']['order'] - 1),array('id','course_id','parent_node_id','type','order'));
			$node = $this->findBottomDescendentInParentNode($node['Node']['course_id'],$immediatePreviousNode);
		} else if(empty($node['Node']['parent_node_id'])) {
			return 0;
		} else {
			$this->contain();
			$node = $this->findById($node['Node']['parent_node_id'],array('id','course_id','parent_node_id','type','order'));
		}
		
		if($node['Node']['type'] == 0) {
			return $node['Node']['id'];
		} else {
			return $this->findPreviousPageId($node);
		}
	}
	
	// Recursive method that returns the bottom descendent
	function findBottomDescendentInParentNode($courseId,$parentNode,$recursionLevel = 0) {
		if($recursionLevel > 5) {
			die('Recursion problem in the node model.');
		}
		
		$this->contain();
		$lastChildNode = $this->find(array('Node.course_id' => $courseId, 'Node.parent_node_id' => $parentNode['Node']['id']),array('id','type'),'Node.order DESC');
		
		if(empty($lastChildNode)) {
			return $parentNode;
		} else {
			return $this->findBottomDescendentInParentNode($courseId,$lastChildNode,$recursionLevel + 1);
		}		
	}
	
	//Recursive method that finds the node to be fetched for the "next" button
	function findNextPageId($node) {
		// Is there a child node?
		$this->contain();
		$firstChildNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $node['Node']['id']),array('id','course_id','parent_node_id','type'),'Node.order ASC');
		if(!empty($firstChildNode)) {
			if($firstChildNode['Node']['type'] == 0) {
				return $firstChildNode['Node']['id'];
			} else {
				return $this->findNextPageId($firstChildNode);
			}
		}

		// Is there a node immediately to the right of this one?
		$this->contain();
		$siblingNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => $node['Node']['order'] + 1),array('id','course_id','parent_node_id','type','order'));
		if(!empty($siblingNode)) {
			if($siblingNode['Node']['type'] == 0) {
				return $siblingNode['Node']['id'];
			} else {
				return $this->findNextPageId($siblingNode);
			}
		}
				
		// Is it at the very end of the root?
		if(empty($node['Node']['parent_node_id']))
			return 0;
				
		// Is there a node immediately to the right of this node's parent?
		$this->contain();
		$parentNode = $this->findById($node['Node']['parent_node_id'],array('id','order','parent_node_id'));
		$this->contain();		
		$uncleNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $parentNode['Node']['parent_node_id'],'Node.order' => $parentNode['Node']['order'] + 1),array('id','course_id','parent_node_id','type'));

		if(!empty($uncleNode)) {
			if($uncleNode['Node']['type'] == 0) {
				return $uncleNode['Node']['id'];
			} else {
				return $this->findNextPageId($uncleNode);
			}
		}	
		
		return 0;
	}
	
	function convert_type($node) {
    	$this->id = $node['Node']['id'];
    	$this->saveField('type', $node['Node']['type']);
	}
	
	function increaseIndent($nodeId){
		return $this->changeIndentation($nodeId);
	}
	
	function decreaseIndent($nodeId) {
		return $this->changeIndentation($nodeId,'decrease');
	}
	
	function changeIndentation($nodeId,$type = 'increase') {
		$this->contain();
		$formerNodeData = $this->findById($nodeId,array('id','type','parent_node_id','course_id','order'));

		if($type == 'increase') {
			if($formerNodeData['Node']['order'] < 1)
				die('Error');

			$this->contain();
			$leftSiblingNode = $this->find(array('Node.course_id' => $formerNodeData['Node']['course_id'],'Node.parent_node_id' => $formerNodeData['Node']['parent_node_id'],'Node.order' => $formerNodeData['Node']['order'] - 1));
			$lastNodeOrderInNewParent = $this->getLastOrderInParentNode($formerNodeData['Node']['course_id'],$leftSiblingNode['Node']['id']);
			$order = $this->field('order',array('Node.course_id' => $formerNodeData['Node']['course_id'], 'Node.parent_node_id' => $leftSiblingNode['Node']['id']),'Node.order DESC');
			
			$newNodeData = array('Node' => array(
				'id' => $nodeId,
				'parent_node_id' => $leftSiblingNode['Node']['id'],
				'order'	=> $lastNodeOrderInNewParent + 1
			));
		} else if($type == 'decrease'){
			$this->contain();
			$oldParentNode = $this->findById($formerNodeData['Node']['parent_node_id'],array('order','parent_node_id'));

			$newNodeData = array('Node' => array(
				'id' => $nodeId,
				'parent_node_id' => $oldParentNode['Node']['parent_node_id'],
				'order' => $oldParentNode['Node']['order'] + 1
			));
		}
		
		$nextSiblingNodeId = $this->field('id',array('Node.course_id' => $formerNodeData['Node']['course_id'],'Node.parent_node_id' => $formerNodeData['Node']['parent_node_id'],'Node.order' => $formerNodeData['Node']['order'] + 1));

		$this->id = $nodeId;
    	$this->save($newNodeData);
		
		$this->updateOrdersWithOldNodeData($formerNodeData);
		if($type == 'decrease') {
			$this->updateOrdersWithNewNodeData($newNodeData);
		}
		
		return $newNodeData;
	}
	
	// Update the node orders to the right of provided node
	function updateOrdersWithOldNodeData($node) {
		$order = $node['Node']['order'];
		$nodes = $this->findAll(array('Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => '> ' . $order));
		
		foreach($nodes as $node) {
			$this->id = $node['Node']['id'];
			$this->saveField('order',$order++);
		}
	}
	
	function updateOrdersWithNewNodeData($node) {
		$order = $node['Node']['order'];
		$this->contain();
		$nodes = $this->findAll(array('Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => '>= ' . $order,'Node.id' => '<> ' . $node['Node']['id']));
				
		foreach($nodes as $node) {
			$this->id = $node['Node']['id'];
			$this->saveField('order',++$order);
		}
	}
	
	function findAllInCourse($courseId,$containers = array()) {
		$this->contain($containers);
		$nodes = $this->findAll(array('Node.course_id' => $courseId),null,'Node.order ASC');
		
		if(empty($nodes))
			return array();
		
		$indexedNodes = array_combine(
			Set::extract($nodes, '{n}.Node.id'),
			Set::extract($nodes, '{n}.Node')
		);
		
		if(@$containers[0] == 'Textarea'){
			$indexedTextareas = array_combine(
				Set::extract($nodes, '{n}.Node.id'),
				Set::extract($nodes, '{n}.Textarea')
			);
			foreach($indexedNodes as &$indexedNode) {
				$indexedNode['Textarea'] = $indexedTextareas[$indexedNode['id']];
			}
		}		
		
		if(@$containers['Question'] == 'Answer'){
			$indexedQuestions = array_combine(
				Set::extract($nodes, '{n}.Node.id'),
				Set::extract($nodes, '{n}.Question')
			);
			foreach($indexedNodes as &$indexedNode) {
				$indexedNode['Question'] = $indexedQuestions[$indexedNode['id']];
			}
		}
		
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
	
	function getSortedNodeItems($node) {
		$nodeItems = array();
		foreach($node['Textarea'] as $textarea) {
			$nodeItems[$textarea['order']] = $textarea;
		}

		foreach($node['Question'] as $question) {
			$nodeItems[$question['order']] = $question;
		}
		ksort($nodeItems);
		
		return $nodeItems;
	}
}