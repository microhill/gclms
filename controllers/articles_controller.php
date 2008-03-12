<?php
class ArticlesController extends AppController {
    var $uses = array('Article');
	var $itemName = 'Article';
	var $components = array('MyAuth');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Articles','/' . $this->viewVars['groupAndCoursePath'] . '/articles');
		parent::beforeRender();
	}

	function index() {
		$this->data = $this->Article->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'Article.title ASC');
	}

	function view($id) {
		$this->Article->contain();
		$this->data = $this->Article->findById($id);
	}
}