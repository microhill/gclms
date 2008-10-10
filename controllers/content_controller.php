<?
class ContentController extends AppController {
    var $uses = array('Node','Group','User','Course');
	var $itemName = 'Node';
	
	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Edit Course Content','/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path']). '/content';
		parent::beforeRender();
	}
	
	function add() {
		$this->data['Node']['course_id'] = $this->viewVars['course']['id'];
		$this->Node->add($this->data); // Needs error checking
		exit;
	}	
	
	function convert_type($id) {
    	$this->data['Node']['id'] = $id;
		$this->Node->convert_type($this->data);
    	exit;
	}
	
	function increase_indent($nodeId) {
		$this->Node->increaseIndent($nodeId);			
    	exit;	
	}
	
	function decrease_indent($nodeId) {
		$this->Node->decreaseIndent($nodeId);			
    	exit;
	}	
    
    function rename($id) {
    	$this->Node->id = $id;
    	$this->Node->saveField('title', $this->data['Node']['title']);
    	exit;
    }
    
	function reorder() {
		if(empty($this->data['Node']['children_nodes']))
			exit;

		$parentNodeId = $this->data['Node']['id'];
		$nodes = explode(',',$this->data['Node']['children_nodes']);

    	$order = 0;
    	foreach($nodes as $nodeId) {
    		$this->Node->id = $nodeId;
    		$this->Node->save(array('Node' => array(
				'parent_node_id' => $parentNodeId,
				'order' => $order
			)));
    		$order++;
    	}

    	exit;
	}
    
    function index() {		
		$this->Node->contain();
		$this->data =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		
		
		$this->set('title',__('Course Content',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));		
    }
    
    function debug() {		
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		$this->set('title','Nodes Debug');
    }
	
	// Fixes the order of nodes; this helps fix navigation button problems
	function clean_up(){
		$this->Node->contain();
		$nodes =  $this->Node->find('all',array(
			'conditions' => array('Node.course_id' => $this->viewVars['course']['id'],'Node.course_id' => $this->viewVars['course']['id'])
		));
		$parent_node_ids = array_unique(Set::extract($nodes,'{n}.Node.parent_node_id'));
		
		foreach($parent_node_ids as $parent_node_id) {
			$this->Node->contain();
			$nodes = $this->Node->find('all',array(
				'conditions' => array('Node.parent_node_id' => $parent_node_id,'Node.course_id' => $this->viewVars['course']['id']),
				'sort' => 'Node.parent_node_id ASC'
			));

			$order = 0;
			foreach($nodes as $node) {
				$this->Node->id = $node['Node']['id'];
				$this->Node->save(array('Node' => array('order' => $order)));
				$order++;
			}
		}
		
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/content/debug');
	}
	
	function fix_orphans() {
		$this->Node->contain();
		$nodes = $this->data = $this->Node->findAll(array('Node.course_id' => $this->viewVars['course']['id']),null,'Node.order ASC');
		$indexedNodes = array_combine(
			Set::extract($nodes, '{n}.Node.id'),
			Set::extract($nodes, '{n}.Node')
		);
		
		foreach($indexedNodes as $node) {
			if(empty($indexedNodes[$node['parent_node_id']])) {
				$this->Node->id = $node['id'];
				$this->Node->saveField('parent_node_id',0);
			}
		}
		
		$this->afterSave();
	}
    
    function view($id) {
		$this->Node->contain();
		$Node = $this->Node->find(array('id' => $id, 'course_id' => $this->viewVars['course']['id']));
		$this->set('Node', $Node['Node']);

		$pages = $this->Page->findAllByNodeId($id);
		$this->set(compact('pages'));
		
		$this->set('topics', array());
    }
	
	function afterSave() {
		$this->redirect = '/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/content'; 
		parent::afterSave();
	}
	
    function delete($id) {
    	$this->Node->delete($id);
    	exit;
    }
}