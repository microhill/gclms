<?php
class GroupsController extends AppController {
    var $uses = array('Group','GroupAdministrator','ClassEnrollee');
	var $helpers = array('Paginator','MyPaginator','Text');
	var $itemName = 'Group';
	var $paginate = array('order' => 'name');

	function beforeFilter() {
		$this->Breadcrumbs->addHomeCrumb();
		
		if($this->Session->check('Auth.User')) {
			$user = $this->Session->read('Auth.User');
			
			$this->ClassEnrollee->contain(array('VirtualClass' => array('Course'=>array('Group'))));
			$enrollees = $this->ClassEnrollee->findAllByUserId($user['id']);
			$this->set('enrollees', $enrollees);
			
			$courses = $this->User->findAllClasses($user['id']);
			$this->set('courses', $courses);
		}
		
		parent::beforeFilter();
	}
	
	function beforeRender() {
		if(isset($this->params['group'])) {
			$this->Breadcrumbs->addCrumb($this->viewVars['group']['name'],'/' . $this->viewVars['group']['web_path']);
			if(!empty($this->viewVars['group']['logo']))
				$this->set('logo',$this->viewVars['group']['logo']);
		} else if($this->action != 'register') {
			$this->Breadcrumbs->addSiteAdministrationCrumb();
			$this->Breadcrumbs->addCrumb('Groups','/administration/groups');
		}
		
		parent::beforeRender();
	}
	
	function show() {
		$this->Course->contain();
		$courses = $this->Course->findAll(array("Course.group_id" => $this->viewVars['group']['id']),null,'Course.title ASC');
		$this->set(compact('courses'));
		
		$this->set('title',$this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('App.name'));
	}

	function register() {
		$this->Breadcrumbs->addCrumb('Register Your Group','/groups/register');
		if(!empty($this->data)) {
			$group = $this->Group->save($this->data);
			$this->GroupAdministrator->save(array('GroupAdministrator' => array(
				'group_id' => $this->Group->getLastInsertId(),
				'user_id' => $this->viewVars['user']['id']
			)));
			$this->User->contain();
			$superAdminsitrators = $this->User->findAll(array('super_administrator' => 1));
			foreach($superAdminsitrators as $superAdminsitrator) {
				mail ($superAdminsitrator['User']['email'], __('Group Application',true), 'Someone has registered a group and is awaiting your approval.');
			}
			$this->Notifications->add(__('Thank you for submitting your group. We will review your submission, and you will be notified by email indicating whether your group has been accepted.',true));
			$this->redirect('/');
			exit;
		}	
	}
}