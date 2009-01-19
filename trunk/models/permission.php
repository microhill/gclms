<?
class Permission extends AppModel {
    var $belongsTo = array('User','Group','Course','VirtualClass');

	var $validate = array(
		'user_id' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
	
	function findAllByUserAndGroup($user_id,$group_id) {
		$this->contain();
		$permissions = $this->find('all',array(
			'conditions' => array(
				'user_id' => $user_id,
				'group_id' => $group_id
		)));
		
		//Classes
		
		//...

		//Courses
		$course_permissions = array();
		foreach($permissions as &$permission) {				
			if(!$permission['Permission']['course_id']) {
				continue;
			}
			
			$course_id = $permission['Permission']['course_id'];
			
			if(empty($course_permissions[$course_id])) {
				$course_permissions[$course_id] = array();
			}
			
			switch($permission['Permission']['model']) {
				case 'Node':
					$course_permissions[$course_id]['manage_content'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
				case 'VirtualClass':
					$course_permissions[$course_id]['add_class_for_approval'] = $this->_check($permission,array('create' => 1,'read' => 0,'update' => 0,'delete' => 0)) ? 1 : 0;
					$course_permissions[$course_id]['add_class_without_approval'] = $this->_check($permission,array('create' => 1,'read' => 0,'update' => 1,'delete' => 0)) ? 1 : 0;
 					break;
				case 'Forum':
					$course_permissions[$course_id]['manage_forums'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
					break;
				case 'ChatMessage': 
					$course_permissions[$course_id]['moderate_chatroom'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;	
					break;
			}
			
			unset($permission);	
		}
		
		//Group-wide
		$group_permissions = array();
		foreach($permissions as &$permission) {				
			switch($permission['Permission']['model']) {
				case 'Permission':
					$group_permissions['manage_user_permissions'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
				case '*':
					$group_permissions['administer'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
				case 'Course':
					$group_permissions['manage_courses'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
				case 'VirtualClass':
					$group_permissions['manage_classes'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
			}
		}
		
		return array(
			'group' => $group_permissions,
			'courses' => $course_permissions 
		);
	}
	
	//Save all permission info for user pertaining to group
	function saveAll($data,$user_id,$group_id) {
		$default = array(
			'user_id' => $user_id,
			'group_id' => $group_id
		);
		
		//Group-wide permissions
		if(!empty($data['Permissions']['group']['administer'])) {
			$this->save(am(array(
				'model' => '*',
				'crud' => array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
			),$default));	
		}

		$this->save(am(array(
			'model' => 'Permission',
			'crud' => empty($data['Permissions']['group']['manage_user_permissions']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));
		
		$this->save(am(array(
			'model' => 'Course',
			'crud' => empty($data['Permissions']['group']['manage_courses']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));

		$this->save(am(array(
			'model' => 'VirtualClass',
			'crud' => empty($data['Permissions']['group']['manage_classes']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));
		
		//Course-wide permissions		
		if(!empty($data['Permissions']['courses'])) {
			foreach($data['Permissions']['courses'] as $course_id => $permissions) {
				$this->save(am(array(
					'course_id' => $course_id,
					'model' => 'Node',
					'crud' => empty($data['Permissions']['courses'][$course_id]['manage_content']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
				),$default));
				
				if($data['Permissions']['courses'][$course_id]['add_class_for_approval']) {
					$this->save(am(array(
						'course_id' => $course_id,
						'model' => 'VirtualClass',
						'crud' => array('_create' => 1,'_read' => 0,'_update' => 0,'_delete' => 0)
					),$default));	
				} else {
					$this->save(am(array(
						'course_id' => $course_id,
						'model' => 'VirtualClass',
						'crud' => empty($data['Permissions']['courses'][$course_id]['add_class_without_approval']) ? array() : array('_create' => 1,'_read' => 0,'_update' => 1,'_delete' => 0)
					),$default));
				}
				
				$this->save(am(array(
					'course_id' => $course_id,
					'model' => 'Forum',
					'crud' => empty($data['Permissions']['courses'][$course_id]['manage_forums']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
				),$default));
				
				$this->save(am(array(
					'course_id' => $course_id,
					'model' => 'ChatMessage',
					'crud' => empty($data['Permissions']['courses'][$course_id]['moderate_chatroom']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
				),$default));
			}	
		}

		//Class-specific permissions
		/*
		foreach($data['Permissions']['classes'] as $class) {
			
		}
		*/
	}
	
	function save($data) {
		$this->id = false;
		$this->data = array();
		
		$crud = $data['crud'];
		unset($data['crud']);

		$permission = $this->find('first',array(
			'conditions' => $data,
			'fields' => 'id',
			'contain' => false
		));
		if(empty($crud) || (empty($crud['_create']) && empty($crud['_read']) && empty($crud['_update']) && empty($crud['_delete']))) {
			if(!empty($permission)) {
				$this->id = $permission['Permission']['id'];
				$this->delete($permission['Permission']['id']);
			}
			return true;
		}
		
		if(!empty($permission)) {
			$this->id = $permission['Permission']['id'];
			$data['id'] = $permission['Permission']['id'];
		}
		
		$data = array('Permission' => array_merge($data,$crud));
		$this->data = $data;
		return parent::save();
	}
	
	/*
	 * $conditions can an array. Or all the arguments can be strings to specify models to check
	 */
	function cache($conditions,$setResults = true) {
		if(is_string($conditions)) {
			$conditions = array('model' => func_get_args());
			$setResults = true;
		}
		
		$user_id = User::get('id');
		if(empty($user_id))
			return false;
		
		$group_id = Group::get('id');
		$course_id = Course::get('id');
		$class_id = VirtualClass::get('id');

		//Check for SiteAdministration
		if(is_array($conditions['model']) && false !== $key = array_search('SiteAdministration',$conditions['model'])) {
			$permission = $this->find('first',array(
				'conditions' => array(
					'Permission.user_id' => $user_id,
					'Permission.model' => '*',
					'Permission.group_id' => null,
					'Permission.course_id' => null,
					'Permission.virtual_class_id' => null,
					'Permission.foreign_key' => null
				),
				'contain' => false,
				'fields' => array('group_id','model')
			));

			if($permission && $setResults)
				Permission::set(array('SiteAdministrator'));

			unset($conditions['model'][$key]);
		}
		
		//Check for GroupAdministration
		if(is_array($conditions['model']) && false !== $key = array_search('GroupAdministration',$conditions['model'])) {
			$permission = $this->find('first',array(
				'conditions' => array(
					'Permission.user_id' => $user_id,
					'Permission.model' => '*',
					'Permission.group_id' => $group_id,
					'Permission.course_id' => null,
					'Permission.virtual_class_id' => null,
					'Permission.foreign_key' => null
				),
				'contain' => false,
				'fields' => array('group_id','model','_create','_read','_update','_delete')
			));

			if($permission && $setResults)
				Permission::set(array($permission));

			unset($conditions['model'][$key]);
		}

		$defaults = array(
			'Permission.user_id' => $user_id,
			'Permission.group_id' => $group_id,
			'Permission.course_id' => $course_id,
			'Permission.virtual_class_id' => $class_id,
			'Permission.foreign_key' => null
		);
	
		if(!empty($conditions['model'])) {
			$permissions = $this->__find($conditions,$defaults);
		} else {
			$permissions = array();
		}
		
		if($setResults)
			Permission::set($permissions);

		return $permissions;
	}
	
	private function __find($conditions,$defaults) {
		if($this->check('SiteAdministrator') || $this->check('CourseAdministrator')) {
			return array(
				'Permission' => am($defaults,$conditions,array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1))
			);
		}

		return $this->find('first',array(
			'conditions' => am($defaults,$conditions),
			'recusive' => false,
			'fields' => array('Permission.group_id','Permission.course_id','Permission.model','Permission.foreign_key','Permission._create','Permission._read','Permission._update','Permission._delete')
		));
	}

	private function _check($data,$actions) {
		foreach($actions as $action_name => $action_permission) {
			if($data['Permission']['_' . $action_name] != $action_permission)
				return false;
		}
		return true;
		/*
		if($data['Permission']['_create'] == @$crud['create']
				&& $data['Permission']['_read'] == $crud['read']
				&& $data['Permission']['_update'] == $crud['update']
				&& $data['Permission']['_delete'] == $crud['delete']) {
			return true;
		}
		return false;
		*/
	}
	
	function allow($model,$actions,$foreign_key) {
		
	}
	
	function &getInstance($permission = null) {
		static $instance = array();

		if ($instance && $permission) {
			$instance[0] =& am($instance[0],$permission);
		} else if($permission) {
			$instance[0] =& $permission;
		}
		
		if (!$instance) {
			return $instance;
		}
	
		return $instance[0];
	}
	
	function set($permission) {
		Permission::getInstance($permission);
	}
	
	function debug() {
		$_permission =& Permission::getInstance();
		prd($_permission);
	}
	
	function get($path = null) {
		$_permission =& Permission::getInstance();
		
		if($path == null) {
			return $_permission;
		}
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'Permission') !== 0) {
			$path = sprintf('Permission/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}
		
		$value = Set::extract($path, $_permission);
		
		if (!$value) {
			return false;
		}
		
		return $value[0];
	}
	
	function check($model,$actions = '*',$foreign_key = null) {
		$permissions = Permission::get();
		$group_id = Group::get('id');
		$course_id = Course::get('id');

		//Check against site admin rights
		if(@$permissions[0] == 'SiteAdministrator') {
			return true;
		}

		//Check against group admin rights
		if($group_id && in_array($model,array('Group','VirtualClass','Permission','Course'))) {
			if(Set::extract('/Permission[group_id=' . $group_id . '][model=*][_create=1][_read=1][_update=1][_delete=1]/.[:first]',$permissions))
				return true;
		}

		//Check against course admin rights
		if($course_id && in_array($model,array('Group','Content','VirtualClass','Permission','Course'))) {
			//If group admin
			if(Set::extract('/Permission[group_id=' . $group_id . '][model=*][_create=1][_read=1][_update=1][_delete=1]/.[:first]',$permissions))
				return true;
		}
		
		/*
		if(@$permissions[1] == 'CourseAdministrator') {
			$group_id = $group_id ? $group_id : $foreign_key;
			if(empty($group_id)) {
				throw Exception('Woops');
			}
			$permission = Set::extract('/Permission[group_id=' . $group_id . '][model=*][_create=1][_read=1][_update=1][_delete=1]/.[:first]',$permissions);
			if(!empty($permission))
				return true;
			return false;
		}
		*/
	
		/*
		if(Group::get('id')) {
			$permission = Set::extract('/Permission[model=*][_create=1][_read=1][_update=1][_delete=1]/.[:first]',$permissions);
			if(!empty($permission))
				return true;
		}
		*/
		
		if($actions = '*' && $foreign_key == null) {
			$permission = Set::extract('/Permission[model=' . $model . '][_create=1][_read=1][_update=1][_delete=1]/.[:first]',$permissions);
			return !empty($permission);
		}
		
		return false;
	}
}