<?php
class GroupAdministratorsController extends AppController {
    var $uses = array('GroupAdministrator','Group','User');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Group administrator';
	var $paginate = array('order' => 'Name');

	function beforeFilter() {
		$this->Breadcrumbs->addStudentCenterCrumb();
		$this->Breadcrumbs->addSiteAdministrationCrumb();
		
		if($this->action != Configure::read('Routing.admin') . '_index')
			$this->Breadcrumbs->addCrumb('Group Administrators','/administration/group_administrators');

		$this->set('groups',$this->Group->generateList());
		parent::beforeFilter();
	}
}