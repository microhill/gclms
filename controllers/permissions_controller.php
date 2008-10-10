<?
class PermissionsController extends AppController {
    var $uses = array('User','Permission');
	var $components = array('Common','Breadcrumbs','Languages','RequestHandler','Notifications');
	var $helpers = array('Paginator','MyPaginator');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('User Permissions','/' . $this->viewVars['groupAndCoursePath'] . '/permissions');
		parent::beforeRender();
	}

	function index() {
		$this->Permission->contain('User');
		$this->data = $this->Permission->find('all',array(
			'conditions' => array('Permission.group_id' => Group::get('id')),
			'fields' => 'DISTINCT User.id'
		));

		$this->paginate['fields'] = array('DISTINCT User.id','User.id','User.first_name','User.last_name');
		$this->data = $this->paginate('Permission',array(
			'Permission.group_id' => Group::get('id')
		));
	}
	
	function add() {
		if(!empty($this->data['User']['search_name'])) {
			$this->data['User']['search_name'] = trim($this->data['User']['search_name']);
			$this->User->contain();
			$user = $this->User->find('first',array(
				'fields' => array('id','username','email'),
				'conditions' => array(				
					'OR' => array(
						'User.email' => $this->data['User']['search_name'],
						'User.username' => $this->data['User']['search_name'])
					)
			));

			if(!empty($user))
				$this->data['User'] = $user['User'];
		} else if(!empty($this->data)) {
			$this->Permission->saveAll($this->data,User::get('id'),Group::get('id'));

			$this->redirect('/' . Group::get('web_path') . '/permissions');
		}
		
		$this->getCoursesAndClasses();
	}
	
	function edit($user_id) {		
		if(empty($user_id))
			die;

		if(!empty($this->data)) {
			$this->Permission->saveAll($this->data,User::get('id'),Group::get('id'));

			$this->redirect('/' . Group::get('web_path') . '/permissions');
		} else {
			$this->data = array();
			
			$this->data['Permissions'] = $this->Permission->findAllByUserAndGroup($user_id,Group::get('id'));
			
			$this->User->contain();
			$user = $this->User->find('first',array(
				'fields' => array('id','username','email'),
				'conditions' => array(				
					'User.id' => $user_id
			)));
			$this->data['User'] = $user['User'];
		}
		$this->getCoursesAndClasses();
	}
	
	private function getCoursesAndClasses() {
		$courses = $this->Course->find('list',array(
			'conditions' => array('Course.group_id' => Group::get('id')),
			'fields' => array('id,title')
		));
		$this->set('courses',$courses);
		
		$this->VirtualClass =& ClassRegistry::init('VirtualClass'); 
		$courses = $this->VirtualClass->find('list',array(
			'conditions' => array('group_id' => Group::get('id')),
			'fields' => array('id','title')
		));
		$this->set('classes',$courses);	
	}
	
	function update() {
		//get all groups, make aco's
		$this->Group->contain();
		$groups = $this->Group->find('all',array(
			
		));
		
		foreach($groups as $group) {
			//Check if group has ACO
			
			/*
			$this->Acl->Aco->create();			
			$this->Acl->Aco->save(array(
				'model' => 'Group',
				'foreign_key' => $group['Group']['id']
			));
			*/
		}

		//
	}
}