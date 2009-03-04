<?
class AssignmentsController extends AppController {
    var $uses = array('Assignment','VirtualClass','Node');
	var $helpers = array('Form','MyForm','Time','MyTime');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Assignments','/' . $this->viewVars['groupAndCoursePath'] . '/assignments');
		parent::beforeRender();
	}

	function index() {
		$this->data = $this->Assignment->find('all',array(
			'conditions' => array(
				'Assignment.course_id' => Course::get('id'),
				'Assignment.virtual_class_id' => VirtualClass::get('id'),
			),
			'order' => 'Assignment.due_date, Assignment.title',
			'contain' => false
		));
	}
	
	function view($id) {
		$this->data = $this->Assignment->find('first',array(
			'conditions' => array('id' => $id),
			'contain' => false
		));
	}
	
	function add() {
		if(!empty($this->data)) {
			if($this->Assignment->save($this->data)) {
				//if(!empty($this->itemName))
					//$this->Notifications->add(__(ucfirst(low($this->itemName)) . ' successfully added.',true));
				
				$this->data['Assignment']['id'] = $this->Assignment->id;
				$this->afterSave();				
			} else {
				//if(!empty($this->itemName))
					//$this->Notifications->add(__('There was an error when attempting to add the ' . low($this->itemName) . '.',true),'error');
			}
		}
	}
	
	function edit($id) {
		if(!empty($this->data)) {
			$this->data['Assignment']['id'] = $id;
			if($this->Assignment->save($this->data)) {				
				//if(!empty($this->itemName))
					//$this->Notifications->add(__(ucfirst(low($this->itemName)) . ' successfully added.',true));
				
				$this->data['Assignments']['id'] = $this->Assignment->id;
				$this->afterSave();
			} else {
				//if(!empty($this->itemName))
					//$this->Notifications->add(__('There was an error when attempting to add the ' . low($this->itemName) . '.',true),'error');
			}
		} else {
			$this->data = $this->Assignment->find('first',array(
				'conditions' => array('Assignment.id' => $id),
				'contain' => false
			));
		}
	}
	
	function delete() {
		foreach($this->data['Assignments'] as $assignment) {
			$this->Assignment->delete($assignment);			
		}
		$this->afterSave();
	}
	
	function save($id = null) {
		$this->cleanUpFields();
		
		if(empty($id)) {
			$this->data['Assignment']['virtual_class_id'] = $this->viewVars['class']['id'];
		}
		parent::save($id);
	}
	
	function afterSave() {
		$this->redirect('/' . $this->viewVars['groupAndCoursePath'] . '/assignments');
	}
}