<?
class ForumsController extends AppController {
    var $uses = array('Forum','ForumPost');
	var $helpers = array('Time','MyTime','Text');

	function beforeFilter() {
		parent::beforeFilter();
		
		$this->Permission->cache('GroupAdministration','Content');
		//if(!Permission::check('Group')) {
			//$this->cakeError('permission');
		//}
	}

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
		//Public forums
		$this->data = $this->Forum->find('all',array(
			'conditions' => array(
				'Forum.course_id' => $this->viewVars['course']['id'],
				'Forum.type' => 3
			),
			'contain' => false
		));
		
		//Template forums
		if(!VirtualClass::get('id') && Permission::check('Content')) {
			$template_forums = $this->Forum->find('all',array(
				'conditions' => array(
					'Forum.course_id' => Course::get('id'),
					'Forum.type' => 0
				),
				'contain' => false
			));
			$this->data = am($this->data,$template_forums);
		}

		if(VirtualClass::get('id')) {		
			//Class forums
			prd('test2');
			if(Permission::check('GroupAdministration') || Permission::check('Content')) {
				$class_forums = $this->Forum->find('all',array(
					'conditions' => array(
						'Forum.course_id' => Course::get('id'),
						'Forum.virtual_class_id' => VirtualClass::get('id'),
						'Forum.type' => 4
					),
					'contain' => false
				));
				$this->data = am($this->data,$class_forums);
			}
		}
		
		//Facilitator forums
		$this->ClassFacilitator =& ClassRegistry::init('ClassFacilitator');
		$class_facilitators = $this->ClassFacilitator->find('all',array(
			'conditions' => array(
				'VirtualClass.course_id' => Course::get('id')
			),
			'contain' => array('VirtualClass' => 'course_id'),
			'fields' => array('id')
		));
		if(Permission::check('GroupAdministration') || !empty($class_facilitators)) {
			$template_forums = $this->Forum->find('all',array(
				'conditions' => array(
					'Forum.course_id' => Course::get('id'),
					'Forum.type' => 2
				),
				'contain' => false
			));
			$this->data = am($this->data,$template_forums);
		}
			
 		//Course enrollee forums - "Open to any user who has been enrolled in course"
		if(!Permission::check('GroupAdministration')) {
			$this->ClassEnrollee =& ClassRegistry::init('ClassEnrollee');
			$course_enrollees = $this->ClassEnrollee->find('all',array(
				'conditions' => array(
					'ClassEnrollee.user_id' => User::get('id'),
					'VirtualClass.course_id' => Course::get('id')
				),
				'contain' => 'VirtualClass',
				'fields' => array('id')
			));			
		}
		if(Permission::check('GroupAdministration') || !empty($course_enrollees)) {
			$course_forums = $this->Forum->find('all',array(
				'conditions' => array(
					'Forum.course_id' => Course::get('id'),
					'Forum.virtual_class_id' => null,
					'Forum.type' => 1
				),
				'contain' => false
			));
			$this->data = am($this->data,$course_forums);
		}
		
		//Get last posts
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
	
	function select() {
		$this->layout = 'blank';
		$forums = $this->Forum->find('all',array(
			'conditions' => array('Forum.course_id' => Course::get('id'))
		));
		$this->set('forums',$forums);
	}
}