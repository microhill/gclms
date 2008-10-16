<?
class ConfigurationController extends AppController {
	var $uses = array('Group');
	var $itemName = 'Group';

	function beforeFilter() {
		parent::beforeFilter();
		$this->Breadcrumbs->addHomeCrumb();
	}

	function beforeRender() {
		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addCrumb(Group::get('name'),'/' . Group::get('web_path'));
		} else {
			$this->Breadcrumbs->addCrumb('Site Administration',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'panel'));
			if($this->action != Configure::read('Routing.admin') . '_index')
				$this->Breadcrumbs->addCrumb('Groups',array(Configure::read('Routing.admin')=>Configure::read('Routing.admin'),'controller'=>'groups','action'=>'index'));
		}
		
		parent::beforeRender();
	}

	function index() {
		$this->Permission->cache('Group');
		
		if(empty($this->data)) {
        	$this->data = $this->Group->findById(Group::get('id'));
		} else {
			parent::edit(Group::get('id'));	
		}
	}
	
	function afterSave() {
		$this->redirect('/' . Group::get('web_path'));
		exit;
	}
}