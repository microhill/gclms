<?
class GroupsController extends AppController {
    var $uses = array('Group','ClassEnrollee');
	var $helpers = array('MyPaginator','Text');
	var $itemName = 'Group';
	var $paginate = array('order' => 'name');

	function beforeFilter() {
		$this->Breadcrumbs->addHomeCrumb();
		
		/*
		if($this->Session->check('Auth.User')) {
			$user = $this->Session->read('Auth.User');
			
			$this->ClassEnrollee->contain(array('VirtualClass' => array('Course'=>array('Group'))));
			$enrollees = $this->ClassEnrollee->findAllByUserId($user['id']);
			$this->set('enrollees', $enrollees);
			
			$courses = $this->User->findAllClasses($user['id']);
			$this->set('courses', $courses);
		}
		*/
		
		parent::beforeFilter();
	}
	
	function beforeRender() {
		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addCrumb(Group::get('name'),'/' . Group::get('web_path'));
		} else if($this->action != 'register') {
			$this->Breadcrumbs->addSiteAdministrationCrumb();
			$this->Breadcrumbs->addCrumb('Groups','/administration/groups');
		}
		
		parent::beforeRender();
	}
	
	function table($page = 1,$limit = 15,$sort = 'name',$direction = 'ASC'){
		$this->data = $this->Group->find('all',array(
			'fields' => array('id','name','web_path'),
			'limit' => $limit,
			'sort' => $sort . ' ' . $direction,
			'recursive' => false
		));
	}
	
	function show() {
		$this->Permission =& ClassRegistry::init('Permission');		
		$this->Permission->cache('Course','Permission','Group','VirtualClass');
		

		/*
		if(User::allow(array(
			'group' => Group::get('id'),
			'model' => 'Course',
			'action' => 'read'
		))) {
			
		} else {
			
		}
		*/

		$this->Course->contain();
		$courses = $this->Course->find('all',array(
			'conditions' => array('Course.group_id' => Group::get('id')),
			'order' => 'Course.title ASC'
		));
		
		$this->set(compact('courses'));
		
		$this->set('title',Group::get('name') . ' &raquo; ' . Configure::read('App.name'));
	}
	/*
	function register() {
		$this->Breadcrumbs->addCrumb('Register Your Group','/groups/register');
		if(!empty($this->data)) {
			$group = $this->Group->save($this->data);
			$this->User->contain();
			$superAdminsitrators = $this->User->findAll(array('super_administrator' => 1));
			foreach($superAdminsitrators as $superAdminsitrator) {
				mail($superAdminsitrator['User']['email'], __('Group Application',true), 'Someone has registered a group and is awaiting your approval.','From: ' . Configure::read('App.administrator_email'));
			}
			$this->Notifications->add(__('Thank you for submitting your group. We will review your submission, and you will be notified by email indicating whether your group has been accepted.',true));
			$this->redirect('/');
			exit;
		}	
	}
	*/
}