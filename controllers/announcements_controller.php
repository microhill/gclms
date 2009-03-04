<?
class AnnouncementsController extends AppController {
    var $uses = array('Announcement','VirtualClass','Node');
	var $helpers = array('Paginator','MyPaginator','Form','MyForm','Time','MyTime');
	var $itemName = 'News Term';
	var $paginate = array('order' => 'title');

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Security->requireAuth('save');
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();

		parent::beforeRender();
	}

	function index() {
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		$this->Assignment =& ClassRegistry::init('Assignment');
		$upcoming_assignments = $this->Assignment->find('all',array(
			'conditions' => array(
				'Assignment.virtual_class_id' => VirtualClass::get('id'),
				'Assignment.due_date <>' => 0
			),
			'contain' => false
		));
		$this->set('upcoming_assignments',$upcoming_assignments);
	}
		
	function save($id = null) {
		$this->cleanUpFields();
		
		if(empty($id)) {
			$this->data['Announcement']['virtual_class_id'] = $this->viewVars['class']['id'];
		}
		parent::save($id);
	}
	
	function afterSave() {
		$this->redirect('/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/news/section:' . $this->viewVars['class']['id']);
	}
}