<?
class ArticlesController extends AppController {
    var $uses = array('Article');
	var $helpers = array('Scripturizer','Glossary');
	var $itemName = 'Article';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Permission->cache('GroupAdministration','Content');
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Articles','/' . $this->viewVars['groupAndCoursePath'] . '/articles');
		parent::beforeRender();
	}

	function index() {
		$this->data = $this->Article->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'Article.title ASC');
		$this->set('title',__('Articles',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));
	}
	
	function add() {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
		$this->Common->add();
	}
	
	function edit($id) {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
		$this->Common->edit($id);
	}
	
	function delete($id) {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
		$this->Common->delete($id);
	}

	function view($id) {
		$this->Article->contain();
		$this->data = $this->Article->findById($id);

		$this->GlossaryTerm =& ClassRegistry::init('GlossaryTerm'); 
		$glossary_terms = $this->GlossaryTerm->findAll(array('course_id'=>$this->viewVars['course']['id']),array('id','term'));
		$this->set('glossary_terms',$glossary_terms);

		$this->set('title',$this->data['Article']['title'] . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));		
	}
	
	function afterSave() {		
		if(!empty($this->Article->id) && $this->action != 'delete') {
			$this->redirect = '/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/articles/view/' . $this->Article->id;
		}
	}
}