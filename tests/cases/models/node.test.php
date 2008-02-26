<?php
App::import('Model','Node');

class NodeTest extends Node {
    var $name = 'Node';
	var $useDbConfig = 'test'; 
}

class NodeTestCase extends CakeTestCase {
    var $fixtures = array('node');
	
	/*
    function testAdd() {
		$this->Node =& new NodeTest();
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 1')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 2')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 3')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 4')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 5')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 6')));
        
        $this->Node->contain();
        $nodes = $this->Node->findAll(array('Node.course_id' => 1),array('id','parent_node_id','order'),'Node.id ASC');

        $expected = array(
            array('Node' => array('parent_node_id' => 0,'previous_page_id' => 0,'next_page_id' => 2,'order' => 0)),
			array('Node' => array('parent_node_id' => 0,'previous_page_id' => 1,'next_page_id' => 5,'order' => 1)),
			array('Node' => array('parent_node_id' => 0,'previous_page_id' => 6,'next_page_id' => 4,'order' => 2)),
			array('Node' => array('parent_node_id' => 0,'previous_page_id' => 3,'next_page_id' => 0,'order' => 3)),
			array('Node' => array('parent_node_id' => 2,'previous_page_id' => 2,'next_page_id' => 6,'order' => 0)),
			array('Node' => array('parent_node_id' => 2,'previous_page_id' => 5,'next_page_id' => 3,'order' => 1))
        );
        
        $this->assertEqual($nodes, $expected);
    }
	
	function testIncreaseIndent() {
		echo '<h3>Increase indent</h3>';
		
		$this->Node =& new NodeTest();
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 1')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 2')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 3')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 4')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 5')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 6')));

        //$nodes = $this->Node->findAll(array('Node.course_id' => 1),array('id','parent_node_id','order'));
		//listNodes($nodes,0);
		//echo '---<br/>';

		$this->Node->increaseIndent(2);
		$this->Node->increaseIndent(4);
		$this->Node->increaseIndent(6);

        $this->Node->contain();
        $nodes = $this->Node->findAll(array('Node.course_id' => 1),array('id','parent_node_id','order'),'Node.id ASC');
		//listNodes($nodes,0);

        $expected = array(
            array('Node' => array('parent_node_id' => 0,'previous_page_id' => 0,'next_page_id' => 2,'order' => 0)),
			array('Node' => array('parent_node_id' => 1,'previous_page_id' => 1,'next_page_id' => 5,'order' => 0)),
			array('Node' => array('parent_node_id' => 0,'previous_page_id' => 6,'next_page_id' => 4,'order' => 1)),
			array('Node' => array('parent_node_id' => 3,'previous_page_id' => 3,'next_page_id' => 0,'order' => 0)),
			array('Node' => array('parent_node_id' => 2,'previous_page_id' => 2,'next_page_id' => 6,'order' => 0)),
			array('Node' => array('parent_node_id' => 5,'previous_page_id' => 5,'next_page_id' => 3,'order' => 0))
        );
        
        $this->assertEqual($nodes, $expected);
	}
	
	*/
	function testDecreaseIndent() {
		echo '<h3>Decrease indent</h3>';

		$this->Node =& new NodeTest();
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 1')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 1,'type' => 0,'title' => 'Test Title 2')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 3')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 2,'type' => 0,'title' => 'Test Title 4')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 1,'type' => 0,'title' => 'Test Title 5')));
		$this->Node->add(array('Node' => array('course_id' => 1,'parent_node_id' => 0,'type' => 0,'title' => 'Test Title 6')));

        $this->Node->contain();
		$nodes = $this->Node->findAll(array('Node.course_id' => 1),array('id','parent_node_id','order'),'Node.order ASC');
		listNodes($nodes,0);
		echo '---<br/>';

		$this->Node->decreaseIndent(2);
		$this->Node->decreaseIndent(3);
		$this->Node->decreaseIndent(5);

		$this->Node->contain();
        $nodes = $this->Node->findAll(array('Node.course_id' => 1),array('id','parent_node_id','order'),'Node.order ASC');
		listNodes($nodes,0);

        $expected = array(
            array('Node' => array('id' => 1,'parent_node_id' => 0,'order' => 0)),
			array('Node' => array('id' => 4,'parent_node_id' => 2,'order' => 0)),
			array('Node' => array('id' => 5,'parent_node_id' => 0,'order' => 1)),
			array('Node' => array('id' => 2,'parent_node_id' => 0,'order' => 2)),
			array('Node' => array('id' => 3,'parent_node_id' => 0,'order' => 3)),
			array('Node' => array('id' => 6,'parent_node_id' => 0,'order' => 4))
        );
        
        $this->assertEqual($nodes, $expected);
	}
}

function listNodes($nodes,$parentNodeId) {
	$firstNodeInList = true;
	foreach($nodes as $node) {
		if($node['Node']['parent_node_id'] == $parentNodeId) {
			if($firstNodeInList)
				echo '<ul>';
			$firstNodeInList = false;
			echo '<li><strong>' . $node['Node']['id'] . '</strong>.<br/>';
			echo 'order: ' . $node['Node']['order'] . '<br/>';
			listNodes($nodes,$node['Node']['id']);
			echo '</li>';			
		}
	}
	if(!$firstNodeInList)
		echo '</ul>';	
}