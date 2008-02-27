<?php
class ProfileController extends AppController {
    var $uses = array('User');
	var $itemName = 'Profile';

	function beforeRender() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addCrumb('Your Profile','/profile');
		parent::beforeRender();
	}
    
	function index() {
		parent::edit($this->viewVars['user']['id']);
	}
	
	function afterSave() {
		$this->redirect('/');
		exit;
	}
}