<?
class PanelController extends AppController {
	var $uses = array();
	
	function beforeRender() {
		$this->Breadcrumbs->addStudentCenterCrumb();
		$this->Breadcrumbs->addSiteAdministrationCrumb();
		parent::beforeRender();
	}
	
	function administration_index() {
		$group_count = $this->Group->findCount(null,0);
		$this->set('group_count',$group_count);
		
		$course_count = $this->Course->findCount(null,0);
		$this->set('course_count',$course_count);	
		
		$user_count = $this->User->findCount(null,0);
		$this->set('user_count',$user_count);	
	}
}