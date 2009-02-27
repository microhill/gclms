<?
class StudentsController extends AppController {
    var $uses = array('ClassEnrollee');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Students','/' . $this->viewVars['groupAndCoursePath'] . '/students');
		parent::beforeRender();
	}

	function index() {
		$enrollees = $this->ClassEnrollee->find('all',array(
			'conditions' => array(
				'ClassEnrollee.virtual_class_id' => VirtualClass::get('id')
			),
			'contain' => array('User' => 'username')
		));
		$this->set('enrollees',$enrollees);

		$this->ClassInvitation =& ClassRegistry::init('ClassInvitation');
		$invitations = $this->ClassInvitation->find('all',array(
			'conditions' => array(
				'ClassInvitation.virtual_class_id' => VirtualClass::get('id')
			),
			'contain' => false
		));
		$this->set('invitations',$invitations);
	}

	function add() {
		if(!empty($this->data)) {
			$user = $this->User->identify($this->data['Student']['identifier']);
			if($user) {
				$this->VirtualClass->addStudent($user['User']['id']);
				$this->afterSave();
			} else if(strpos($this->data['Student']['identifier'],'@') !== false) {
				$this->render('invite_prompt');
			}
		}
	}

	function invite() {
		//$this->VirtualClass->inviteStudent($this->data['Student']);
		
		if(!empty($this->data)) {
			if($this->VirtualClass->inviteStudent($this->data['Student']['identifier']))
				$this->afterSave();
		}
	}

	function view($id) {
		/*
		$this->data = $this->Enrollee->find('all',array(
			'conditions' => array(
				'virtual_class_id' => VirtualClass::get('id')
			)
		));
		*/
	}
	
	function afterSave() {
		$this->redirect('/' . $this->viewVars['groupAndCoursePath'] . '/students');
	}
}