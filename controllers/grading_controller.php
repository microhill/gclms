<?php
class GradingController extends AppController {
	var $uses = array();
	var $components = array('Security');

	function beforeFilter() {
		//$this->Security->requireAuth('save');
		$this->Security->requirePost('save');
		$this->Breadcrumbs->addHomeCrumb();
		parent::beforeFilter();
	}

	function beforeRender() {
		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addCrumb($this->viewVars['group']['name'],array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'panel'));
		} else {
			$this->Breadcrumbs->addCrumb('Site Administration',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'panel'));
			if($this->action != Configure::read('Routing.admin') . '_index')
				$this->Breadcrumbs->addCrumb('Groups',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'groups','action'=>'index'));
		}
		
		parent::beforeRender();
	}

	function index() {
	}
}