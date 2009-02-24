<?
class AdministratorsController extends AppController {
    var $uses = array('User','Group');
	var $helpers = array('MyPaginator','Menu');
	var $itemName = 'Administrator';
	var $paginate = array(
		'order' => 'username',
		'limit' => 12
	);

	function beforeFilter() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addSiteAdministrationCrumb();
		
		if($this->action != Configure::read('Routing.admin') . '_index') {
			$this->Breadcrumbs->addCrumb('Administrators','/administration/administrators');
		}
		
		$this->set('groups',$this->Group->generateList());
		parent::beforeFilter();
		
		if(!Permission::check('SiteAdministration')) {
			$this->cakeError('permission');
		}
	}
	
	function table($page = 1,$limit = 15,$sort = 'User.username',$direction = 'ASC'){
		$this->data = $this->Permission->find('all',array(
			'conditions' => array(
				'virtual_class_id' => null,
				'model' => '*'
			),
			'fields' => array('DISTINCT User.id','User.username','User.first_name','User.last_name'),
			'limit' => $limit,
			'sort' => $sort . ' ' . $direction,
			'contain' => array('User')
		));
	}
	
	function administration_add() {
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
			
			$groups_administering = $this->Permission->find('all',array(
				'conditions' => array(
					'user_id' => $user['User']['id'],
					'course_id' => null,
					'model' => '*'
				),
				'fields' => array('group_id'),
				'contain' => false
			));
			$this->set('groups_administering',$groups_administering);

			if(!empty($user))
				$this->data['User'] = $user['User'];
		} else if(!empty($this->data)) {
			if($this->save($this->data))
				$this->redirect('/administration/administrators');
		}
		
		$groups = $this->Group->find('list',array(
			'fields' => array('id','name')
		));
		$this->set('groups',$groups);
	}
	
	function administration_edit($id) {
		if(empty($id)) {
			die;	
		}
		
		if(!empty($this->data)) {
			if($this->save($this->data))
				$this->redirect('/administration/administrators');
		}
		
		$this->User->contain();
		$user = $this->User->find('first',array(
			'fields' => array('id','username','email'),
			'conditions' => array(				
				'User.id' => $id
		)));
		$this->data['User'] = $user['User'];
		
		$site_administrator = $this->Permission->find('first',array(
			'conditions' => array(
				'user_id' => $user['User']['id'],
				'group_id' => null,
				'course_id' => null,
				'model' => '*'
			),
			'fields' => array('id'),
			'contain' => false
		));
		$this->set('site_administrator',!empty($site_administrator));
		
		$groups_administering = $this->Permission->find('all',array(
			'conditions' => array(
				'user_id' => $user['User']['id'],
				'group_id <>' => null,
				'course_id' => null,
				'model' => '*'
			),
			'fields' => array('group_id'),
			'contain' => false
		));
		$groups_administering = Set::extract($groups_administering, '{n}.Permission.group_id');
		$this->set('groups_administering',$groups_administering);			
		
		$groups = $this->Group->find('list',array(
			'fields' => array('id','name')
		));
		$this->set('groups',$groups);
	}
	
	function save() {
		if($this->data['SiteAdministrator']) {
			$this->Permission->save(array(
				'user_id' => $this->data['User']['id'],
				'group_id' => null,
				'course_id' => null,
				'virtual_class_id' => null,
				'model' => '*',
				'crud' => array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			));
		} else {
			$this->Permission->save(array(
				'user_id' => $this->data['User']['id'],
				'group_id' => null,
				'course_id' => null,
				'virtual_class_id' => null,
				'model' => '*',
				'crud' => array()
			));
		}
		
		$groups = $this->Group->find('all',array(
			'fields' => array('id'),
			'contain' => false
		));
		
		//prd($groups);
		//prd($this->data);
		
		foreach($groups as $group) {
			if(@$this->data['Groups'][$group['Group']['id']]) {
				$this->Permission->save(array(
					'group_id' => $group['Group']['id'],
					'user_id' => $this->data['User']['id'],
					'course_id' => null,
					'virtual_class_id' => null,
					'foreign_key' => null,
					'model' => '*',
					'crud' => array(
						'_create' => 1,
						'_read' => 1,
						'_update' => 1,
						'_delete' => 1
					)
				));
			} else {
				$this->Permission->save(array(
					'group_id' => $group['Group']['id'],
					'user_id' => $this->data['User']['id'],
					'course_id' => null,
					'virtual_class_id' => null,
					'foreign_key' => null,
					'model' => '*',
					'crud' => array(
						'_create' => 0,
						'_read' => 0,
						'_update' => 0,
						'_delete' => 0
					)
				));
			}
		}
		
		return true;
	}
}