<?
class ContentController extends AppController {
    var $uses = array('Node','Group','FacilitatedClass','User','Course');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Node';
	
	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Edit Course Content','/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']). '/content';
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

    	$order = 1;
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
		$this->data = $this->Node->findAll(array('Node.course_id' => $this->viewVars['course']['id']),null,'Node.order ASC');
		
		$this->set('title',__('Course Content',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);		
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
		$this->redirect = '/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/Nodes'; 
		parent::afterSave();
	}
	
    function delete($id) {
    	$this->Node->delete($id);
    	exit;
    }
}