<?php
class FacilitatorsController extends AppController {
	var $uses = array('GroupFacilitator','GroupFacilitator','Group','User');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Facilitator';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();

		parent::beforeRender();
	}

	function index() {
		if($this->viewVars['group']) {
			//$this->Lesson->unbindModel(array('belongsTo' => array('Course'),'hasMany' => array('Page','Slideshow','Assessment')));
			//$lesson = $this->Lesson->find(array('Lesson.order' => $this->passedArgs['lesson'], 'Lesson.course_id' => $this->viewVars['course']['id']));

			$data = $this->paginate();
			$this->set(compact('data'));
		} else {
			$this->siteCatalogue();			
		}	
	}
	
	function register() {
		if($this->data || 0) {
			$group = $this->Group->save($this->data);
			$this->GroupFacilitator->save(array('GroupFacilitator' => array(
				'group_id' => $this->viewVars['group']['id'],
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
	
	function afterSave() {
		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/facilitators');
		exit;
	}
}