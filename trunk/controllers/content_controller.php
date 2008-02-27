<?
class ContentController extends AppController {
    var $uses = array('Node','Group','FacilitatedClass','User','Course');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Node';

	function beforeRender() {
		//$this->defaultBreadcrumbsAndLogo();
		//if($this->action == 'view')
			//$this->Breadcrumbs->addCrumb(__('Nodes',true), $this->viewVars['groupAndCoursePath'] . '/Nodes/view/' . $this->passedArgs[0]);
		
//		$this->addCrumb($this->controller->viewVars['Node']['title'], $this->viewvars['groupAndCoursePath'] . '/Node/view/' . $Node['Node']['id']);
		
		parent::beforeRender();
	}
	
	function add() {
		$this->data['Node']['course_id'] = $this->viewVars['course']['id'];
		echo $this->Node->add($this->data);
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