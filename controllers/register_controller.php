<?php
class RegisterController extends AppController {
    var $uses = array('User');

    function beforeFilter() {
		$this->MyAuth->allowedActions = array('*');
		//$this->Security->requirePost('save');
		$this->Breadcrumbs->addHomeCrumb();
		parent::beforeFilter();
    }

    function thank_you() {}

    function index() {
    	if(!empty($this->data)) {
			if($this->User->findByUsername($this->data['User']['new_username'])) {
				$this->Notifications->add(__('The username you provided is already in use.',true),'error');
				return false;
			}
			if($this->data['User']['new_password'] != $this->data['User']['repeat_new_password']) {
				$this->Notifications->add(__('Passwords do not match.',true),'error');
				return false;
			}
			if($this->User->findByEmail($this->data['User']['email'])) {
				$this->Notifications->add(__('The e-mail you provided is already in use by another username.',true),'error');
				return false;
			}

			$this->data['User']['email'] = $this->data['User']['new_username'];
			$this->data['User']['password'] = Security::hash(Configure::read('Security.salt') . $this->data['User']['new_password'], 'sha1');
			$this->data['User']['verification_code'] = String::uuid();
			$this->User->create();
			$this->User->save($this->data);
			
			mail($this->data['User']['email'],__('Student registration',true),sprintf(__('Thank you for registering as a student. Visit the following URL to verify your student account.\b\b ' . DOMAIN . 'users/verify/' . $this->data['User']['verification_code'],true)), 'From: aaronshaf@gmail.com');
			$this->Notifications->add(__('Thank you for registering as a student. Please check your e-mail to activate your student account.',true));
			$this->redirect('/');
			exit;
    	}
	}
}