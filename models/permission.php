<?
class Permission extends AppModel {
    var $belongsTo = array('User','Group','Course','VirtualClass');
	
	function save($data) {
		$this->id = null;
		
		$crud = $data['crud'];
		unset($data['crud']);
		$this->contain('id');
		$permission = $this->find('first',array(
			'conditions' => array($data),
			'fields' => 'id'
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
		}
		
		$data = array_merge($data,$crud);

		return parent::save($data);
	}
	
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
				case 'Course':
					$group_permissions['manage_courses'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
 					break;
				case 'Permission':
					$group_permissions['manage_user_permissions'] = $this->_check($permission,array('create' => 1,'read' => 1,'update' => 1,'delete' => 1)) ? 1 : 0;
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
	
	private function _check($data,$crud) {
		if($data['Permission']['_create'] == $crud['create']
				&& $data['Permission']['_read'] == $crud['read']
				&& $data['Permission']['_update'] == $crud['update']
				&& $data['Permission']['_delete'] == $crud['delete']) {
			return true;
		}
		return false;
	}
	
	function saveAll($data,$user_id,$group_id) {
		$default = array(
			'user_id' => $user_id,
			'group_id' => $group_id
		);
		
		$this->save(am(array(
			'model' => 'Course',
			'crud' => empty($data['Permissions']['group']['manage_courses']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));

		$this->save(am(array(
			'model' => 'Permission',
			'crud' => empty($data['Permissions']['group']['manage_user_permissions']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));

		$this->save(am(array(
			'model' => 'VirtualClass',
			'crud' => empty($data['Permissions']['group']['manage_classes']) ? array() : array('_create' => 1,'_read' => 1,'_update' => 1,'_delete' => 1)
		),$default));
		
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
		
		/*
		foreach($data['Permissions']['classes'] as $class) {
			
		}
		*/
	}
		
	function cache($conditions,$setResults = false) {
		if(is_string($conditions)) {
			$conditions = array('model' => func_get_args());
			$setResults = true;
		}
		
		$user_id = User::get('id');
		$user_id = $user_id ? $user_id : null;
		
		$group_id = Group::get('id');
		$group_id = $group_id ? $group_id : null;
		
		$course_id = Course::get('id');
		$course_id = $course_id ? $course_id : null;
		
		$class_id = VirtualClass::get('id');
		$class_id = $course_id ? $class_id : null;

		$defaults = array(
			'user_id' => $user_id,
			'group_id' => $group_id,
			'course_id' => $course_id,
			'virtual_class_id' => $class_id,
			'foreign_key' => null
			);

		$permissions = $this->find('all',array(
			'conditions' => am(array(
				'model' => $conditions['model']
			),$defaults),
			'contain' => false,
			'fields' => array('group_id','course_id','model','foreign_key','_create','_read','_update','_delete')
		));
		
		if($setResults)
			Permission::set($permissions);
		
		return $permissions;
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
		if($actions = '*' && $foreign_key == null) {
			$permission = Set::extract('/Permission[model=' . $model . '][_create=1][_read=1][_update=1][_delete=1]/.[:first]',Permission::get());
			return !empty($permission);
		}
		
		return false;
	}
}