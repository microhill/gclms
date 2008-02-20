<?php
class ClassController extends AppController {
    var $uses = array('FacilitatedClass','Announcement');
	var $components = array('MyAuth');
	var $helpers = array('License');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		//$this->Breadcrumbs->addCrumb('Articles','/' . $this->viewVars['groupAndCoursePath'] . '/articles');
		parent::beforeRender();
	}

	function index() {
		$id = $this->params['class'];

		$this->Unit->contain();
		$units = $this->Unit->findAll(array("Unit.course_id" => $this->viewVars['course']['id']),null,'Unit.order ASC');
		$this->set(compact('units'));

		$this->Lesson->contain();
		$lessons = $this->Lesson->findAll(array("Lesson.course_id" => $this->viewVars['course']['id']),null,'Lesson.order ASC');
		$this->set(compact('lessons'));

		$this->Announcement->contain();
		$news_items = $this->Announcement->findAllByFacilitatedClassId($id);
		$this->set('news_items',$news_items);
		
		$this->set('title',$this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('Site.name'));
	}
}