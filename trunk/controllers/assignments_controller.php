<?
class AssignmentsController extends AppController {
    var $uses = array('Assignment','VirtualClass','Node');
	var $helpers = array('Form','MyForm','Time','MyTime','Menu');

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
	
	function add() {
		/*
		if(!empty($this->data)) {
			if($this->{$model}->save($this->data)) {
				if(!empty($this->itemName))
					$this->Notifications->add(__(ucfirst(low($this->itemName)) . ' successfully added.',true));
				
				$this->data[$model]['id'] = $this->{$model}->id;
				$this->afterSave();				
			} else {
				if(!empty($this->itemName))
					$this->Notifications->add(__('There was an error when attempting to add the ' . low($this->itemName) . '.',true),'error');
			}
		}
		*/
	}
	
	function edit($id = null) {
		
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