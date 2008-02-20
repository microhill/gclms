<?
class DiscussionController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function forums() {
		return $this->index();
	}
	function index() {
		$this->data = $this->Forum->findAll();
		return $this->render('forums','tabbed_viewport');
	}
	
	function add_forum() {
		//if(!empty($this->data))
			//{pr($this->data);die;}
		
		parent::add('Forum');
		return $this->render('add_forum','tabbed_viewport');
	}
	
	function edit_forum() {
		parent::edit('Forum');
		return $this->render('edit_forum','tabbed_viewport');
	}
	
	function delete_forum($id) {
		$post = $this->ForumPost->findById($id);
		$this->set('forum',$post['Forum']);
		
		if($this->Forum->delete($id))
		
		$this->afterSave();	
	}
	
	function forum($id) {
		$this->set('forum',$this->Forum->findById($id));
		$this->data = $this->ForumPost->findAllByForumId($id);
		return $this->render('forum','tabbed_viewport');
	}
	
	function add_topic() {
		$this->set('forum',$this->Forum->findById($this->passedArgs['forum']));
		
		if(!empty($this->data)) {
			$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
		}
		
		parent::add('ForumPost');
		return $this->render('add_topic','tabbed_viewport');
	}
	
	function edit_topic() {
		parent::edit('ForumPost');
		return $this->render('edit_topic','tabbed_viewport');
	}
	
	function topic($id) {
		$this->ForumPost->contain(array('Forum','User','Reply' => 'User'));
		$this->data = $this->ForumPost->findById($id);
		return $this->render('topic','tabbed_viewport');
	}
	
	function reply($id) {
		$this->data['ForumPost'] = $this->data['Reply'];

		if(!empty($this->passedArgs['topic'])) {
			$this->data['ForumPost']['parent_post_id'] = $this->passedArgs['topic'];
		}
		
		$this->data['ForumPost']['user_id'] = $this->viewVars['user']['id'];
				
		return parent::add('ForumPost');
	}
	
	function afterSave() {
		if($this->action == 'add_topic' || $this->action == 'edit_topic') {
			$this->redirect($this->viewVars['groupAndCoursePath'] . '/discussion/forum/' . $this->viewVars['forum']['Forum']['id']);
		}
		if($this->action == 'reply') {
			$this->redirect($this->viewVars['groupAndCoursePath'] . '/discussion/topic/' . $this->passedArgs['topic']);
		}
		parent::afterSave();	
	}
}