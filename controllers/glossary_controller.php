<?
class GlossaryController extends AppController {
    var $uses = array('GlossaryTerm');
	var $helpers = array('Menu');
	var $itemName = 'Glossary Term';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Permission->cache('GroupAdministration','Content');
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Glossary','/' . $this->viewVars['groupAndCoursePath'] . '/glossary');
		parent::beforeRender();
	}
	
	function index() {
		$this->data = $this->GlossaryTerm->findAllByCourseId(array('course_id'=>$this->viewVars['course']['id']),null,'GlossaryTerm.term ASC');
		$this->set('title',__('Glossary',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));
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
		$this->GlossaryTerm->contain();
		$this->data = $this->GlossaryTerm->findById($id);
		
		$this->set('title',$this->data['GlossaryTerm']['term'] . ' &raquo; ' . __('Glossary',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));		
	}

	function table() {
		$data = $this->paginate(null,array('GlossaryTerm.course_id' => $this->viewVars['course']['id']));
		$this->set(compact('data'));
	}
	
	function afterSave() {
		if(!empty($this->data['GlossaryTerm']['id']) && $this->action != 'delete') {
			$this->redirect = '/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/glossary/view/' . $this->data['GlossaryTerm']['id'];
		}
	}
}