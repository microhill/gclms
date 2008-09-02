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
		'GroupsFacilitating' => array(
				'className'    => 'Group',
				'joinTable'    => 'group_facilitators',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'group_id',
				'unique'       => true,
				'fields' 		=> array('id','web_path','name')
			),
		'ClassesTaking' => array(
				'className'    => 'VirtualClass',
				'joinTable'    => 'class_enrollees',
				'foreignKey'   => 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'       => true,
				'fields' 		=> array('id','alias')
			),
		'ClassesFacilitating'	=> array(
				'className'   	=> 'VirtualClass',
				'joinTable'   	=> 'class_facilitators',
				'foreignKey' 	=> 'user_id',
				'associationForeignKey'=> 'virtual_class_id',
				'unique'      	=> true,
				'fields'		=> array('id','alias')
			)
	);
	
	var $validate = array(
		'email' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'alias' => array(
			'rule' => VALID_NOT_EMPTY
		),		
		'new_password' => array(
			'rule' => array('checkNewPassword')
		),
		'repeat_new_password' => array(
			'rule' => array('doNothing')
		),
		'first_name' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'last_name' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);	
	
	function doNothing() { // for now!
		return true;
	}
	
	function checkNewPassword() {
		if(empty($this->data['User']['new_password']) && empty($this->data['User']['repeat_new_password']))
			return true;
			//Configure::read('Security.salt')
		if($this->data['User']['new_password'] == $this->data['User']['repeat_new_password']) {
			$this->data['User']['password'] = Security::hash(Configure::read('Security.salt') . $this->data['User']['repeat_new_password'], 'sha1');
			return true;
		} else
			return false;
	}
    
    function findAllGroups($id) {
    	$groups = $this->findById($id,array('id'));
    	$groups1 = count($groups['GroupsAdministrating']) ?
			array_combine(
	        	Set::extract($groups, 'GroupsAdministrating.{n}.web_path'),
				Set::extract($groups, 'GroupsAdministrating.{n}.name')
			) : array();
    	$groups2 = count($groups['GroupsFacilitating']) ?
			array_combine(
	        	Set::extract($groups, 'GroupsFacilitating.{n}.web_path'),
				Set::extract($groups, 'GroupsFacilitating.{n}.alias')
			) : array();
		return $groups1 + $groups2;
    }
    
    function findAllClasses($id) {
    	$groups = $this->findById($id,array('id'));
    	$groups1 = count(($groups['ClassesTaking'])) ?
			array_combine(
	        	Set::extract($groups, 'ClassesTaking.{n}.id'),
				Set::extract($groups, 'ClassesTaking.{n}.alias')
			) : array();
    	$groups2 = count($groups['ClassesFacilitating']) ?
			array_combine(
	        	Set::extract($groups, 'ClassesFacilitating.{n}.id'),
				Set::extract($groups, 'ClassesFacilitating.{n}.alias')
			) : array();
		return $groups1 + $groups2;	
    }
}