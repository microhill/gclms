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
		$this->Forum->contain(array('LastPost' => 'User'));
		$this->data = $this->Forum->find('all');
	}
	
	function view($id) {
		$this->set('forum',$this->Forum->findById($id));
		$this->data = $this->ForumPost->find('all',array(
			'conditions' => array('ForumPost.forum_id' => $id,'ForumPost.parent_post_id' => '')
		));
	}
}