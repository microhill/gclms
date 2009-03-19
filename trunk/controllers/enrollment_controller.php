<?
class EnrollmentController extends AppController {
    var $uses = array('VirtualClass','ClassEnrollee');
	var $helpers = array('Paginator','MyPaginator','MyForm','Time','MyTime','Menu');
	var $paginate = array('order' => 'title');
	var $components = array('RequestHandler');

	function beforeFilter() {
		parent::beforeFilter();
		
		/*
		$this->Permission->cache('GroupAdministration');
		if(!Permission::check('Group')) {
			$this->cakeError('permission');
		}
		*/
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		if($this->action == 'index') {
			$this->Breadcrumbs->addCrumb('Classes','/' . Group::get('web_path') . '/classes');
		}
		parent::beforeRender();
	}
	
	function index() {
	
	}
	
	function proceed() {
		if(!$this->RequestHandler->isPost()) {
			die;
		}

		//Check for existing enrollment
		$classEnrollee = $this->ClassEnrollee->find('first',array(
			'conditions' => array(
				'user_id' => User::get('id'),
				'virtual_class_id' => VirtualClass::get('id')
			),
			'contain' => false
		));
		
		if(!empty($classEnrollee)) {
			$this->Notifications->add(__('You are already enrolled in this class.',true),'error');
			$this->redirect($this->viewVars['groupAndCoursePath']);
		}

		if((float) VirtualClass::get('price')) {

		} else {
			if($this->ClassEnrollee->save(array(
				'user_id' => User::get('id'),
				'virtual_class_id' => VirtualClass::get('id')
			))) {
				$this->Notifications->add(__('Enrollment submitted. Awaiting approval from class facilitator.',true),'success');
			} else {
				$this->Notifications->add(__('An error occured when attempting enrollment.',true),'error');
			}

		}
	}
	
	function payment() {
	
	}
}