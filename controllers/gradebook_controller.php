<?
class GradebookController extends AppController {
    var $uses = array('ClassGrade','ClassEnrollee','Assignment');

	function beforeFilter() {
		parent::beforeFilter();
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Assignments','/' . $this->viewVars['groupAndCoursePath'] . '/gradebook');
		parent::beforeRender();
	}

	function index() {
		$assignments = $this->Assignment->find('all',array(
			'conditions' => array(
				'Assignment.virtual_class_id' => VirtualClass::get('id')
			),
			'order' => 'Assignment.due_date',
			'contain' => false
		));		
		$this->set('assignments',$assignments);
		
		$enrollees = $this->ClassEnrollee->find('all',array(
			'conditions' => array(
				'ClassEnrollee.virtual_class_id' => VirtualClass::get('id')
			),
			'order' => 'User.username',
			'contain' => array('User' => array(
				'fields' => array('id','username'),
				'ClassGrade'
			))
		));
		$this->set('enrollees',$enrollees);
	}
}