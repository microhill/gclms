<?
class AdministratorsController extends AppController {
    var $uses = array('User','Group');
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
	}
	
	function administration_index() {
		//$data = $this->paginate();
		//prd($this);

		$data = $this->Permission->find('all',array(
			'conditions' => array(
				'virtual_class_id' => null,
				'model' => '*'
			),
			'fields' => 'DISTINCT User.id',
			'contain' => array('User')
		));
		prd($data);
		$this->set(compact('data'));
		//pr($this->paginate);
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
			$this->save($this->data);		
			$this->redirect('/administration/administrators');
			
			//$this->Permission->saveAll($this->data,User::get('id'),Group::get('id'));
			//$this->redirect('/' . Group::get('web_path') . '/permissions');
		}
		
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
			if($this->data['Groups'][$group['Group']['id']]) {
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
	}
}