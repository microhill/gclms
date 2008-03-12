<?
class DictionaryController extends AppController {
    var $uses = array('DictionaryTerm');
	var $itemName = 'Dictionary Term';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Dictionary','/' . $this->viewVars['groupAndCoursePath'] . '/dictionary');
		parent::beforeRender();
	}
	
	function index() {
		$this->data = $this->DictionaryTerm->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'DictionaryTerm.term ASC');
		$this->set('title',__('Dictionary',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
	}

	function table() {
		$data = $this->paginate(null,array('DictionaryTerm.course_id' => $this->viewVars['course']['id']));
		$this->set(compact('data'));
	}
}