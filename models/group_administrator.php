<?php
class GroupAdministrator extends AppModel {
	var $belongsTo = array('Group','User');
	
	var $validate = array(
		'username' => array(
			'rule' => 'validUsername'
		)
	);
	
	function validUsername() {
		if(empty($this->data['GroupAdministrator']['username']))
			return false;

		ClassRegistry::init('User');
		$this->User =& new User();

		$this->User->contain();
		$user = $this->User->findByUsername($this->data['GroupAdministrator']['username'],'id');

		if(!empty($user)) {
			$this->data['GroupAdministrator']['user_id'] = $user['User']['id'];
			return true;
		}
		return true;
	}
}