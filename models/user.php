<?
class User extends AppModel {   
	var $recursive = 1;
    
	var $hasAndBelongsToMany = array(
		'GroupsAdministrating' => array(
				'className'    => 'Group',
				'joinTable'    => 'group_administrators',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'group_id',
				'unique'       => true,
				'fields' 		=> array('id','web_path','name')
			),
		/*'GroupsFacilitating' => array(
				'className'    => 'Group',
				'joinTable'    => 'group_facilitators',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'group_id',
				'unique'       => true,
				'fields' 		=> array('id','web_path','name')
			),*/
		'ClassesTaking' => array(
				'className'    => 'VirtualClass',
				'joinTable'    => 'class_enrollees',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'       => true,
				'fields' 		=> array('id','title')
			),
		/*
		'ClassesFacilitating'	=> array(
				'className'   	=> 'VirtualClass',
				'joinTable'   	=> 'class_facilitators',
				'foreignKey' 	=> 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'      	=> true,
				'fields'		=> array('id','title')
			)
		*/
	);
	
	function beforeSave() {
		if($this->id) {
			return true;
		}
		$this->data['User']['verification_code'] = String::uuid();
		mail($this->data['User']['email'],__('Student registration',true),sprintf(__("Thank you for registering as a student. Visit the following URL to verify your student account: " . Configure::read('App.domain') . 'users/verify/' . $this->data['User']['verification_code'],true)), 'From: aaronshaf@gmail.com');
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
			array('rule' => 'checkNewPassword','message' => 'Passwords do not match'),
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
	
	function checkNewPassword() {
		if($this->id && empty($this->data['User']['new_password']) && empty($this->data['User']['repeat_new_password']))
			return true;
			//Configure::read('Security.salt')
		if($this->data['User']['new_password'] == $this->data['User']['repeat_new_password']) {
			$this->data['User']['password'] = Security::hash(Configure::read('Security.salt') . $this->data['User']['repeat_new_password'], 'sha1');
			return true;
		}
		return false;
	}
    
    function findAllGroups($id) {
    	$groups = $this->findById($id,array('id'));
    	$groups1 = count($groups['GroupsAdministrating']) ?
			array_combine(
	        	Set::extract($groups, 'GroupsAdministrating.{n}.web_path'),
				Set::extract($groups, 'GroupsAdministrating.{n}.name')
			) : array();
    	/*
		$groups2 = count($groups['GroupsFacilitating']) ?
			array_combine(
	        	Set::extract($groups, 'GroupsFacilitating.{n}.web_path'),
				Set::extract($groups, 'GroupsFacilitating.{n}.alias')
			) : array();
		*/
		return $groups1; // + $groups2;
    }
    
    function findAllClasses($id) {
    	$groups = $this->findById($id,array('id'));
    	$groups1 = count(($groups['ClassesTaking'])) ?
			array_combine(
	        	Set::extract($groups, 'ClassesTaking.{n}.id'),
				Set::extract($groups, 'ClassesTaking.{n}.alias')
			) : array();
    	/*
		$groups2 = count($groups['ClassesFacilitating']) ?
			array_combine(
	        	Set::extract($groups, 'ClassesFacilitating.{n}.id'),
				Set::extract($groups, 'ClassesFacilitating.{n}.alias')
			) : array();
		*/
		//return $groups1 + $groups2;	
		return $groups1;
    }
}