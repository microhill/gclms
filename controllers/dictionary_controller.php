<?
class DictionaryController extends AppController {
    var $uses = array('DictionaryTerm');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Dictionary Term';
	var $paginate = array('order' => 'term');
	var $components = array('MyAuth');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Dictionary','/' . $this->viewVars['groupAndCoursePath'] . '/dictionary');
		parent::beforeRender();
	}
	
	function panel(){
		$this->DictionaryTerm->contain();
		$dictionary_terms = $this->DictionaryTerm->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'DictionaryTerm.term ASC');
		$this->set('dictionary_terms',$dictionary_terms);
		$this->render('show','classroom_panel');
		exit;
	}
	
	function index() {
		if($this->params['isAjax'] && empty($this->passedArgs['page'])) {
			$this->DictionaryTerm->contain();
			$dictionary_terms = $this->DictionaryTerm->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'DictionaryTerm.term ASC');
			$this->set('dictionary_terms',$dictionary_terms);
			$this->render('show','blank');
			exit;
		}

	    $this->table();

	    if($this->RequestHandler->isAjax())
	    	$this->render('table','ajax');
	}

	function table() {
		$data = $this->paginate(null,array('DictionaryTerm.course_id' => $this->viewVars['course']['id']));
		$this->set(compact('data'));
	}
}