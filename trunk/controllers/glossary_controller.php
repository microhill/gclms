<?
class GlossaryController extends AppController {
    var $uses = array('GlossaryTerm');
	var $itemName = 'Glossary Term';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Glossary','/' . $this->viewVars['groupAndCoursePath'] . '/glossary');
		parent::beforeRender();
	}
	
	function index() {
		$this->data = $this->GlossaryTerm->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'GlossaryTerm.term ASC');
		$this->set('title',__('Glossary',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
	}
	
	function view($id) {
		$this->GlossaryTerm->contain();
		$this->data = $this->GlossaryTerm->findById($id);
		
		$this->set('title',$this->data['GlossaryTerm']['term'] . ' &raquo; ' . __('Glossary',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);		
	}

	function table() {
		$data = $this->paginate(null,array('GlossaryTerm.course_id' => $this->viewVars['course']['id']));
		$this->set(compact('data'));
	}
}