<?
class ArticlesController extends AppController {
    var $uses = array('Article');
	var $itemName = 'Article';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Articles','/' . $this->viewVars['groupAndCoursePath'] . '/articles');
		parent::beforeRender();
	}

	function index() {
		$this->data = $this->Article->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'Article.title ASC');
		$this->set('title',__('Articles',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
	}

	function view($id) {
		$this->Article->contain();
		$this->data = $this->Article->findById($id);
		
		$this->set('title',$this->data['Article']['title'] . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);		
	}
	
	function afterSave() {		
		if(!empty($this->data['Article']['id']) && $this->action != 'delete') {
			$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/articles/view/' . $this->data['Article']['id']);
		} else {
			$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/articles');
		}
		exit;
	}
}