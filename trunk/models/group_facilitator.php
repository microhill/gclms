<?php
class GroupFacilitator extends AppModel {
	var $belongsTo = array('Group','User');
	
	var $validate = array(
		'username' => array(
			'rule' => 'validUser'
		)
	);
	
	function validUser() {
		ClassRegistry::init('User');
		$this->User =& new User();

		$this->User->contain();
		$user = $this->User->findByUsername($this->data['GroupFacilitator']['username'],array('id'));
		if(empty($user))
			return false;
			
		$this->data['GroupFacilitator']['user_id'] = $user['User']['id'];
		return true;
	}
}