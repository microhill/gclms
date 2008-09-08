<?
class ForumsController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Forums','/' . $this->viewVars['groupAndCoursePath'] . '/forums');
		parent::beforeRender();
	}	
	
	function add() {
		if(!empty($this->data)) {
			if(!empty($this->viewVars['class'])) {
				$this->data['Forum']['class_id'] = $this->viewVars['class']['id'];
			}

			$this->data['Forum']['course_id'] = $this->viewVars['course']['id'];
		}
		parent::add();
	}
	
	function index() {
		$this->Forum->contain();
		$this->data = $this->Forum->find('all',array(
			'conditions' => array('Forum.course_id' => $this->viewVars['course']['id'])
		));
		foreach($this->data as &$forum) {
			$this->ForumPost->contain('User');
			$forum['Forum']['last_post'] = $this->ForumPost->find('first',array(
				'conditions' => array('ForumPost.forum_id' => $forum['Forum']['id']),
				'order' => 'ForumPost.created DESC'
			));
		}
	}
	
	function view($id) {
		$this->set('forum',$this->Forum->findById($id));
		$this->data = $this->ForumPost->find('all',array(
			'conditions' => array('ForumPost.forum_id' => $id,'ForumPost.parent_post_id' => '')
		));
		foreach($this->data as &$forum_post) {
			$forum_post['ForumPost']['reply_count'] = $this->ForumPost->find('count',array(
				'conditions' => array('ForumPost.origin_post_id' => $forum_post['ForumPost']['id'])
			));
			$this->ForumPost->contain('User');
			$forum_post['ForumPost']['last_post'] = $this->ForumPost->find('first',array(
				'conditions' => array('ForumPost.origin_post_id' => $forum_post['ForumPost']['id']),
				'order' => 'ForumPost.created DESC'
			));
		}
	}
}