<?
class ForumsController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}
	
	function index() {
		$this->data = $this->Forum->findAll();
	}	
	
	function edit() {
		parent::edit('Forum');
	}
	
	function delete($id) {
		$post = $this->ForumPost->findById($id);
		$this->set('forum',$post['Forum']);
		
		if($this->Forum->delete($id))
		
		$this->Common->afterSave();	
	}
	
	function view($id) {
		$this->set('forum',$this->Forum->findById($id));
		$this->data = $this->ForumPost->findAllByForumId($id);
	}
	
	function afterSave2() {	
	}
}