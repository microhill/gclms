<?php
class GroupAdministrator extends AppModel {
	var $belongsTo = array('Group','User');
	
	var $validate = array(
		'email' => array(
			'rule' => 'validEmail'
		)
	);
	
	function validEmail() {
		if(empty($this->data['GroupAdministrator']['email']))
			return false;

		ClassRegistry::init('User');
		$this->User =& new User();

		$this->User->contain();
		$user = $this->User->findByEmail($this->data['GroupAdministrator']['email'],'id');

		if(!empty($user)) {
			$this->data['GroupAdministrator']['user_id'] = $user['User']['id'];
			return true;
		}
		return true;
	}
}