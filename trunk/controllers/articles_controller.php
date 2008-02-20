<?php
class ArticlesController extends AppController {
    var $uses = array('Article');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Article';
	var $paginate = array('order' => 'Article.title');
	var $components = array('MyAuth');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Articles','/' . $this->viewVars['groupAndCoursePath'] . '/articles');
		parent::beforeRender();
	}

	function index() {
	    $this->table();

	    if($this->RequestHandler->isAjax())
	    	$this->render('table','ajax');
	}
	
	function panel(){
		$this->Article->contain();
		$articles = $this->Article->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'Article.title ASC');
		$this->set('articles',$articles);
		$this->render('show','classroom_panel');
		exit;
	}

	function table() {
		$data = $this->paginate(null,array('Article.course_id' => $this->viewVars['course']['id']));
		$this->set(compact('data'));
	}

	function view($id) {
		$this->Article->contain();
		$article = $this->Article->findById($id);
		$this->set('article',$article);
		$this->render('view','classroom_panel');
		exit;
	}
}