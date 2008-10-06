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
			'conditions' => array('Permission.group_id' => $this->viewVars['group']['id']),
			'fields' => 'DISTINCT User.id'
		));

		$this->paginate['fields'] = array('DISTINCT User.id','User.id','User.first_name','User.last_name');
		$this->data = $this->paginate('Permission',array(
			'Permission.group_id' => $this->viewVars['group']['id']
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
			$this->save_permissions();

			$this->redirect('/' . $this->viewVars['group']['web_path'] . '/permissions');
		}
		
		$this->getCoursesAndClasses();
	}
	
	function edit($user_id) {		
		if(empty($user_id))
			die;
		
		$this->data = array();
		
		$this->data['Permissions'] = $this->Permission->getFromUser($user_id,$this->viewVars['group']['id']);
		
		$this->User->contain();
		$user = $this->User->find('first',array(
			'fields' => array('id','username','email'),
			'conditions' => array(				
				'User.id' => $id
		)));
		$this->data['User'] = $user['User'];
		
		$this->getCoursesAndClasses();
	}
	
	private function getCoursesAndClasses() {
		$this->Course->contain('id','title');
		$courses = $this->Course->find('list',array(
			'conditions' => array('Course.group_id' => $this->viewVars['group']['id'])
		));
		$this->set('courses',$courses);
		
		$this->VirtualClass =& ClassRegistry::init('VirtualClass'); 
		$this->VirtualClass->contain('id','title');
		$courses = $this->VirtualClass->find('list',array(
			'conditions' => array('group_id' => $this->viewVars['group']['id'])
		));
		$this->set('classes',$courses);	
	}
	
	private function save_permissions() {
		$default = array(
			'user_id' => $this->viewVars['user']['id'],
			'group_id' => $this->viewVars['group']['id']
		);
		
		$this->Permission->save(am(array(
			'model' => 'Course',
			'crud' => empty($this->data['Permissions']['group']['manage_courses']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));

		$this->Permission->save(am(array(
			'model' => 'Permission',
			'crud' => empty($this->data['Permissions']['group']['manage_user_permissions']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));

		$this->Permission->save(am(array(
			'model' => 'VirtualClass',
			'crud' => empty($this->data['Permissions']['group']['manage_classes']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));
		
		foreach($this->data['Permissions']['courses'] as $course_id => $permissions) {
			$this->Permission->save(am(array(
				'course_id' => $course_id,
				'model' => 'Node',
				'crud' => empty($this->data['Permissions']['courses'][$course_id]['manage_content']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			),$default));
			
			if($this->data['Permissions']['courses'][$course_id]['add_class_for_approval']) {
				$this->Permission->save(am(array(
					'course_id' => $course_id,
					'model' => 'VirtualClass',
					'crud' => array('_create' => 1,'_read' => 0,'_update' => 0,'_delete' => 0)
				),$default));	
			} else {
				$this->Permission->save(am(array(
					'course_id' => $course_id,
					'model' => 'VirtualClass',
					'crud' => empty($this->data['Permissions']['courses'][$course_id]['add_class_without_approval']) ? array() : array('_create' => 1,'_read' => 0,'_update' => 1,'_delete' => 0)
				),$default));
			}
			
			$this->Permission->save(am(array(
				'course_id' => $course_id,
				'model' => 'Forum',
				'crud' => empty($this->data['Permissions']['courses'][$course_id]['manage_forums']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			),$default));
			
			$this->Permission->save(am(array(
				'course_id' => $course_id,
				'model' => 'ChatMessage',
				'crud' => empty($this->data['Permissions']['courses'][$course_id]['moderate_chatroom']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			),$default));
		}
		
		/*
		foreach($this->data['Permissions']['classes'] as $class) {
			
		}
		*/
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