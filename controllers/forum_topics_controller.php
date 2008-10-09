<?
class ForumTopicsController extends AppController {
    var $uses = array('ForumPost','Forum');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}
	
	function add() {
		$this->set('forum',$this->Forum->findById($this->passedArgs['forum']));
		
		if(!empty($this->data)) {
			$this->data['ForumPost']['user_id'] = User::get('id');
		}

		return parent::add('ForumPost');
	}

	function afterSave() {
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/forum_topics/view/' . $this->ForumPost->id);	
	}

	function delete($id) {
		$this->redirect = $this->viewVars['groupAndCoursePath'] . '/forums/view/' . $this->ForumPost->field('forum_id',array('id' => $id));	
		return parent::delete($id);
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
		$this->data['ForumPost']['origin_post_id'] = $this->data['ForumPost']['parent_post_id'] = $id;
		$this->data['ForumPost']['forum_id'] = $this->ForumPost->field('forum_id',array('ForumPost.id' => $id));
		
		$this->data['ForumPost']['user_id'] = User::get('id');
		$this->redirect = Controller::referer();
		return parent::add('ForumPost');
	}
}