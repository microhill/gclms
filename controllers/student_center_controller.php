<?
class StudentCenterController extends AppController {
	var $uses = array('ClassEnrollee');
    var $components = array('RequestHandler','Breadcrumbs');

	function beforeFilter() {
		if($this->Session->check('Auth.User')) {
			$user = $this->Session->read('Auth.User');
			$groups = $this->User->findAllGroups($user['id']);
			$this->set('groups', $groups);

			$this->ClassEnrollee->contain(array('VirtualClass' => array('Course'=>array('Group'))));

			$enrollees = $this->ClassEnrollee->findAllByUserId($user['id']);
			$this->set('enrollees', $enrollees);

			$courses = $this->User->findAllClasses($user['id']);
			$this->set('courses', $courses);
		}

       	if(isset($this->passedArgs['course'])) {
			$course = $this->Course->find(array("Course.web_path" => $this->passedArgs['course']));
			$this->set('course', $course['Course']);
       	}

		parent::beforeFilter();	
	}
	
    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
    	
    	parent::beforeRender();
    }

    function index(){
		$this->set('participating_groups',$this->Group->find('all',array(
			'order' => 'Group.created DESC',
			'limit' => 5,
			'contain' => false
		)));
		
		$this->set('new_courses',$this->Course->find('all',array(
			'order' => 'Course.created DESC',
			'limit' => 5,
			'contain' => array('Group' => array('web_path'))
		)));

		$isFeed = ife($this->RequestHandler->prefers('rss') == 'rss', true, false);

		// provide different title and a description for the feed
		if ($isFeed) {
			$this->set('channel', array('title' => 'New Courses at the Internet Biblical Seminary', 'description' => 'A list of courses that have recently been made available on the Internet Biblical Seminary.'));
		}
		
		$this->set('title','Internet Biblical Seminary - A hub for evangelical Christian e-learning');
    }
}