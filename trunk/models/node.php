<?
/*
 * Node type: 0 - page, 1 - label
 */
class Node extends AppModel {
    var $recursive = 1;

    var $belongsTo = array(
		/* 'ParentNode' => array(
			'className' => 'Node',
			'foreignKey' => 'parent_node_id',
			'fields' => array('id')
		), */
		'Course'
	);

	var $hasMany = array(
		'Textarea',
		'Question',
		'ChildNode' => array(
			'className' => 'Node',
			'foreignKey' => 'parent_node_id',
			'fields' => array('id')
		)
	);

	function add($node) {
		$this->id = null;
		$node['Node']['order'] = $this->getLastOrderInParentNode($node['Node']['course_id'],$node['Node']['parent_node_id']) + 1;
		$this->save($node);
		
		if(empty($node['Node']['id']))
			$node['Node']['id'] = $this->getLastInsertId();
			
		$this->updatePreviousAndNextConnections($node);
		
		return $node['Node']['id'];
	}
	
	function getLastOrderInParentNode($courseId,$parentNodeId) {
		$order = $this->field('order',array('Node.course_id' => $courseId, 'Node.parent_node_id' => $parentNodeId),'Node.order DESC');
		return $order === false ? -1 : $order;
	}
	
	function updatePreviousAndNextConnections($node) {
		$previousPageId = $this->findPreviousPageId($node);
		$nextPageId = $this->findNextPageId($node);
		$this->id = $node['Node']['id'];
		
		$this->save(array('Node' => array(
			'previous_page_id' => $previousPageId,
			'next_page_id' => $nextPageId
		)));
		
		$this->updateNextPageId($previousPageId);
		$this->updatePreviousPageId($nextPageId);
	}
		
	function updatePreviousPageId($nodeId) {
		$node = $this->findById($nodeId);
		$this->id = $nodeId;

		$previousPageId = $this->findPreviousPageId($node);
		$this->saveField('previous_page_id',$previousPageId);
	}
	
	function updateNextPageId($nodeId) {
		$node = $this->findById($nodeId);
		$this->id = $nodeId;

		$nextPageId = $this->findNextPageId($node);
		$this->saveField('next_page_id',$nextPageId);
	}
	
	// Finds previous node of type page; recursive
	function findPreviousPageId($node) {
		if($node['Node']['order'] > 0) {
			$immediatePreviousNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => $node['Node']['order'] - 1),array('id','type','order'));
			$node = $this->findBottomDescendentInParentNode($node['Node']['course_id'],$immediatePreviousNode);
		} else if(empty($node['Node']['parent_node_id'])) {
			return 0;
		} else {
			$this->contain();
			$node = $this->findById($node['Node']['parent_node_id'],array('id','course_id','parent_node_id','type'));
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
		$siblingNode = $this->find(array('Node.course_id' => $node['Node']['course_id'],'Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => $node['Node']['order'] + 1),array('id','course_id','parent_node_id','type'));
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
		$this->updatePreviousAndNextConnections($node);
	}
	
	function increaseIndent($nodeId){
		return $this->changeIndentation($nodeId);
	}
	
	function decreaseIndent($nodeId) {
		return $this->changeIndentation($nodeId,'decrease');
	}
	
	function changeIndentation($nodeId,$type = 'increase') {
		$this->contain();
		$formerNodeData = $this->findById($nodeId,array('id','type','previous_page_id','next_page_id','parent_node_id','course_id','order'));

		if($type == 'increase') {
			if($formerNodeData['Node']['order'] < 1)
				die('Error');

			$this->contain();
			$leftSiblingNode = $this->find(array('Node.parent_node_id' => $formerNodeData['Node']['parent_node_id'],'Node.order' => $formerNodeData['Node']['order'] - 1));
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

		$this->id = $nodeId;
    	$this->save($newNodeData);
		
		$this->updateOrdersWithOldNodeData($formerNodeData);
		if($type == 'decrease') {
			$this->updateOrdersWithNewNodeData($newNodeData);
		}
		
		$newNodeData = array('Node' => am($formerNodeData['Node'],$newNodeData['Node']));

		if($formerNodeData['Node']['type'] != 0 || $type == 'increase')
			return $newNodeData;
			
		if(!empty($formerNodeData['Node']['previous_page_id']))
			$this->updateNextPageId($formerNodeData['Node']['previous_page_id']);
		
		if(!empty($formerNodeData['Node']['next_page_id']))
			$this->updatePreviousPageId($formerNodeData['Node']['next_page_id']);

		$this->updatePreviousAndNextConnections($newNodeData);
		
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
		$nodes = $this->findAll(array('Node.parent_node_id' => $node['Node']['parent_node_id'],'Node.order' => '>= ' . $order,'Node.id' => '<> ' . $node['Node']['id']));
		
		foreach($nodes as $node) {
			$this->id = $node['Node']['id'];
			$this->saveField('order',++$order);
		}
	}	
	
	// getLastOrderInCourse
	
	/*
    function findAllByLessonAndTopic($lessonId,$topicId) {
    	$pages = $this->findAll(array('Page.lesson_id' => $lessonId,'Page.topic_id' => $topicId,'Page.topic_head' => 0),null,'Page.order ASC');
    	return $pages;
    }

    function findAllByLessonId($lessonId) {
	    $this->contain();
		return $this->findAll(array('Page.lesson_id' => $lessonId), array('id','title','Page.topic_head','topic_id','order'),'Page.order ASC');
    }

    function findFirstInLesson($lessonId) {
		$this->contain('id');
    	$page = $this->find(array('Page.lesson_id' => $lessonId,'Page.topic_head' => 1),null,'Page.order ASC');
    	if(!empty($page))
    		return $page;

    	$this->contain('id');
    	$page = $this->find(array('Page.lesson_id' => $lessonId,'Page.topic_head' => 0,'Page.topic_id' => 0),null,'Page.order ASC');
    	if(!empty($page))
    		return $page;

    	return null;
    }

	// Looks for the previous page in a lesson, and returns the id
	function findPreviousPageId($page = null) {
		if(empty($page)) {
			$this->contain(array('id','order','topic_id','lesson_id','topic_head'));
			$page = $this->findById($this->id);
		}

		$page = $page['Page'];
		list($lessonId,$topicId,$order,$topicHead) = array($page['lesson_id'],$page['topic_id'],$page['order'],$page['topic_head']);

		if($order > 1 && !$topicHead) {
			$this->contain();
			$pageId = $this->field('id',array('lesson_id' => $lessonId,'Page.topic_head' => $topicHead, 'topic_id' => $topicId,'Page.order' => $order - 1));
			if(!empty($pageId))
				return $pageId;
		}

		if(!empty($topicId)) {
			return $topicId;
		} else if($topicHead) {
			$this->contain();
			// Get previous topic

			$topicId = $this->field('id',array('lesson_id' => $lessonId,'Page.topic_head' => 1,'Page.order' => $order - 1));
		} else {
			$this->contain();
			// Get last topic
			$topicId = $this->field('id',array('lesson_id' => $lessonId,'Page.topic_head' => 1),'Page.order DESC');
		}
		if(empty($topicId))
			return null;

		$this->contain();
		$tmpPageId = $this->field('id',array('lesson_id' => $lessonId,'topic_id' => $topicId),'Page.order DESC');

		if(empty($tmpPageId))
			return $topicId;

		return $tmpPageId;
	}

	// Looks for the next page in a lesson and returns the id
	function findNextPageId($page = null) {
		if(empty($page)) {
			$this->contain(array('id','order','topic_id','lesson_id','topic_head'));
			$page = $this->findById($this->id);
		}

		$page = $page['Page'];
		$lessonId = $page['lesson_id'];

		// If page isn't topic head
		if(empty($page['topic_head'])) {
			// Find page with next order
			$pageId = $this->field('id',array('Page.lesson_id' => $lessonId,'topic_id' => $page['topic_id'],'Page.order' => $page['order'] + 1));
			if(!empty($pageId))
				return $pageId;

			if(!empty($page['topic_id']))
				$topicOrder = $this->field('order',array('id' => $page['topic_id']));
			else
				return null; // Is last uncategorized page
		} else { // If page is topic head
			// Find first page in topic
			$pageId = $this->field('id',array('Page.lesson_id' => $lessonId,'topic_id' => $page['id']),'Page.order ASC');
			if(!empty($pageId))
				return $pageId;

			$topicOrder = $page['order'];
		}

		// Find topic with next topic order
		$pageId = $this->field('id',array('Page.lesson_id' => $page['lesson_id'],'Page.topic_head' => 1,'Page.order' => $topicOrder + 1));
		if(!empty($pageId))
			return $pageId;

		// Find first uncategorized page
		$pageId = $this->field('id',array('Page.lesson_id' => $page['lesson_id'],'Page.topic_id' => 0,'Page.topic_head' => 0),'Page.order ASC');
		if(!empty($pageId))
			return $pageId;

		return null;
	}

    function getLastPageOrderInTopic($topicId, $lessonId = null) {
		return $this->field('order',array(
			'Page.topic_id' => $topicId,
			'Page.topic_head' => 0,
			'Page.lesson_id' => $lessonId
		),'Page.order DESC');
    }

    function getLastPageInTopic($topicId, $lessonId = null) {
		$this->contain();
		return $this->find(array(
			'Page.topic_id' => $topicId,
			'Page.topic_head' => 0,
			'Page.lesson_id' => $lessonId
		),null,'Page.order DESC');
    }
	*/
}