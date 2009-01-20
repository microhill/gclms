<?
class AssignmentsController extends AppController {
    var $uses = array('Assignment','VirtualClass','Node');
	var $helpers = array('Form','MyForm','Time','MyTime');

	function beforeFilter() {
		parent::beforeFilter();
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();

		parent::beforeRender();
	}

	function index() {
		//$this->Node->contain();
		//$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		//$this->set(compact('nodes'));
	}
	
	function save($id = null) {
		$this->cleanUpFields();
		
		if(empty($id)) {
			$this->data['Assignment']['virtual_class_id'] = $this->viewVars['class']['id'];
		}
		parent::save($id);
	}
	
	function afterSave() {
		//$this->redirect('/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/news/section:' . $this->viewVars['class']['id']);
	}
}