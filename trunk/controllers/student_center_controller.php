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
		$this->set('my_groups',$this->User->findAllGroups(User::get('id')));
		$this->set('my_classes',$this->User->findAllClasses(User::get('id')));

		$this->set('participating_groups',$this->Group->findLatestParticipating());
		$this->set('new_courses',$this->Course->findLatestPublished());

		// provide different title and a description for the feed
		$isFeed = ife($this->RequestHandler->prefers('rss') == 'rss', true, false);
		if ($isFeed) {
			$this->set('channel', array('title' => 'New Courses at the Internet Biblical Seminary', 'description' => 'A list of courses that have recently been made available on the Internet Biblical Seminary.'));
		}
		
		$this->set('title','Internet Biblical Seminary - A hub for evangelical Christian e-learning');
    }
}