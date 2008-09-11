<?
class ConfigurationController extends AppController {
	var $uses = array('Group');
	var $itemName = 'Group';

	function beforeFilter() {
		$this->Breadcrumbs->addHomeCrumb();
		parent::beforeFilter();
	}

	function beforeRender() {
		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addCrumb($this->viewVars['group']['name'],'/' . $this->viewVars['group']['web_path']);
		} else {
			$this->Breadcrumbs->addCrumb('Site Administration',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'panel'));
			if($this->action != Configure::read('Routing.admin') . '_index')
				$this->Breadcrumbs->addCrumb('Groups',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'groups','action'=>'index'));
		}
		
		parent::beforeRender();
	}

	function index() {
		if(empty($this->data)) {
        	$this->data = $this->Group->findById($this->viewVars['group']['id']);
		} else {
			parent::edit($this->viewVars['group']['id']);	
		}
	}
	
	function afterSave() {
		$this->redirect('/' . $this->viewVars['groupWebPath']);
		exit;
	}
}