<?
class User extends AppModel {   
	var $recursive = 0;
    
	var $hasAndBelongsToMany = array(
		'ClassesTaking' => array(
				'className'    => 'VirtualClass',
				'joinTable'    => 'class_enrollees',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'       => true,
				'fields' 		=> array('id','title')
			),
		'ClassesFacilitating'	=> array(
				'className'   	=> 'VirtualClass',
				'joinTable'   	=> 'class_facilitators',
				'foreignKey' 	=> 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'      	=> true,
				'fields'		=> array('id','title')
		)
	);
	
	function beforeSave($data) {
		if($this->id || !$this->find('first')) {
			return true;
		}

		try {
			$this->data['User']['verification_code'] = String::uuid();
			mail($this->data['User']['email'],__('Student registration',true),sprintf(__("Thank you for registering as a student. Visit the following URL to verify your student account: " . Configure::read('App.domain') . 'users/verify/' . $this->data['User']['verification_code'],true)), 'From: aaronshaf@gmail.com');
		} catch(Exception $e) {
		
		}
		
		return true;
	}
	
	var $validate = array(
		'email' => array(
			array('rule' => VALID_NOT_EMPTY,'message' => 'This field cannot be left blank'),
			array('rule' => 'notDuplicateEmail','message' => 'The email you provided is already in use')
		),
		'alias' => array(
			array('rule' => VALID_NOT_EMPTY,'message' => 'This field cannot be left blank'),
			array('rule' => 'notDuplicateAlias','message' => 'The alias you provided is already in use')
		),		
		'new_password' => array(
			array('rule' => 'checkDepulicatePassword','message' => 'Passwords do not match'),
			array('rule' => VALID_NOT_EMPTY,'message' => 'This field cannot be left blank')
		),
		'repeat_new_password' => array(
			array('rule' => VALID_NOT_EMPTY,'message' => 'This field cannot be left blank')
		),
		'first_name' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'last_name' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
	
	function notDuplicateEmail() {
		if($this->id) {
			return true;
		}
		
		$this->contain();
		$user = $this->findByEmail($this->data['User']['email']);
		if(!empty($user))
			return false;
		return true;
	}
	
	function notDuplicateAlias() {
		if($this->id) {
			return true;
		}
		
		$this->contain();
		$user = $this->findByAlias($this->data['User']['alias']);
		if(!empty($user))
			return false;
		return true;
	}
	
	function doNothing() { // for now!
		return true;
	}
	
	function checkDuplicatePassword() {
		if($this->id && empty($this->data['User']['new_password']) && empty($this->data['User']['repeat_new_password']))
			return true;
		if($this->data['User']['new_password'] == $this->data['User']['repeat_new_password']) {
			$this->data['User']['password'] = Security::hash($this->data['User']['repeat_new_password'], 'sha1',true);
			return true;
		}
		return false;
	}
    
    function findAllGroups($id) {
		$this->Permission =& ClassRegistry::init('Permission');
		$groups = $this->Permission->find('all',array(
			'conditions' => array(
				'user_id' => User::get('id'),
				'group_id <>' => null,
				'course_id' => null, 
				'model' => '*',
			),
			'fields' => array('id'),
			'contain' => array('Group' => array('web_path','name'))
		));
		if(!empty($groups)) {
			$groups = array_combine(
				Set::extract($groups,'{n}.Group.web_path'),
				Set::extract($groups,'{n}.Group.name')
			);			
		} else {
			$groups = array();
		}
		
		/*
		$user = $this->find('first',array(
			'conditions' => array('id' => $id),
			'fields' => 'id',
			'contain' => array('GroupsAdministrating')
		));
    	$groups = count($user['GroupsAdministrating']) ?
			array_combine(
	        	Set::extract($user, 'GroupsAdministrating.{n}.web_path'),
				Set::extract($user, 'GroupsAdministrating.{n}.name')
			) : array();
		return $groups;
		*/
		return $groups;
    }
    
    function findAllClasses($id) {
		$user = $this->find('first',array(
			'conditions' => array('id' => $id),
			'fields' => 'id',
			'contain' => array('ClassesTaking')
		));
    	$classes1 = count(($user['ClassesTaking'])) ?
			array_combine(
	        	Set::extract($user, 'ClassesTaking.{n}.id'),
				Set::extract($user, 'ClassesTaking.{n}.alias')
			) : array();
    	/*
		$groups2 = count($groups['ClassesFacilitating']) ?
			array_combine(
	        	Set::extract($groups, 'ClassesFacilitating.{n}.id'),
				Set::extract($groups, 'ClassesFacilitating.{n}.alias')
			) : array();
		*/
		//return $groups1 + $groups2;	
		return $classes1;
    }
	
	// See "Accessing User Sessions From Models (or Anywhere)" at http://www.pseudocoder.com/archives/2008/10/06/accessing-user-sessions-from-models-or-anywhere-in-cakephp-revealed/
	
	function &getInstance($user = null) {
		static $instance = array();
		
		if($user) {
			$instance[0] =& $user;
		}
		
		if (!$instance) {
			//trigger_error(__('User not set.', true), E_USER_WARNING);
			return $instance;
		}
	
		return $instance[0];
	}
	
	function set($user) {
		User::getInstance($user);
	}
	
	function get($path) {
		$_user =& User::getInstance();
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'User') !== 0) {
			$path = sprintf('User/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}
		
		$value = Set::extract($path, $_user);
		
		if (!$value) {
			return null;
		}
		
		return $value[0];
	}
	
	function allow($options) {
		return true;	
	}
	
	function identify($data) {
		$password = Security::hash($data['User']['password'], 'sha1',true);
		
		if(strpos($data['User']['username'],'@') !== false) {
			$user = $this->find('first',array(
				'conditions' => array(
					'User.email' => $data['User']['username'],
					'User.password' => $password
				),
				'fields' => array('id','email','username','first_name','last_name','display_full_name','verified')
			));
		} else if(strpos($data['User']['username'],'http://') === false) {
			$this->contain('ClassesTaking');
			$user = $this->find('first',array(
				'conditions' => array(
					'User.username' => $data['User']['username'],
					'User.password' => $password,
				),
				'fields' => array('id','email','username','first_name','last_name','display_full_name','verified')
			));
		} else {
			//OpenID	
		}

		if(empty($user))
			return false;
			
		return $user;
	}
}