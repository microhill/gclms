<?
class ForumPostsController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}
	
	function add_topic() {
		$this->set('forum',$this->Forum->findById($this->passedArgs['forum']));
		
		if(!empty($this->data)) {
			$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
		}
		
		parent::add('ForumPost');
		return $this->render('add_topic');
	}
	
	function edit_topic() {
		parent::edit('ForumPost');
		return $this->render('edit_topic');
	}
	
	function topic($id) {
		$this->ForumPost->contain(array('Forum','User','Reply' => 'User'));
		$this->data = $this->ForumPost->findById($id);
		return $this->render('topic');
	}
	
	function reply($id) {
		$this->data['ForumPost'] = $this->data['Reply'];

		if(!empty($this->passedArgs['topic'])) {
			$this->data['ForumPost']['parent_post_id'] = $this->passedArgs['topic'];
		}
		
		$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
				
		return parent::add('ForumPost');
	}
}