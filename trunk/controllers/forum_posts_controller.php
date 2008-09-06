<?
class ForumPostsController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}
	
	function add() {
		$this->set('forum',$this->Forum->findById($this->passedArgs['forum']));
		
		if(!empty($this->data)) {
			$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
		}
		
		parent::add('ForumPost');
		return $this->render('add');
	}
	
	function edit() {
		parent::edit('ForumPost');
		return $this->render('edit');
	}
	
	function view($id) {
		if(!empty($id) && !empty($this->data)) {
			$this->reply($id);
		}
		
		$this->ForumPost->contain(array('Forum','User','Reply' => 'User'));
		$this->data = $this->ForumPost->findById($id);
	}
	
	function reply($id) {
		$this->data['ForumPost'] = $this->data['Reply'];
		$this->data['ForumPost']['parent_post_id'] = $id;
		
		$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
		$this->redirect = Controller::referer();
		return parent::add('ForumPost');
	}
}