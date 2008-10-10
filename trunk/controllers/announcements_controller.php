<?
class AnnouncementsController extends AppController {
    var $uses = array('Announcement','VirtualClass','Node');
	var $helpers = array('Paginator','MyPaginator','Form','MyForm','Time','MyTime');
	var $itemName = 'News Term';
	var $paginate = array('order' => 'title');
	var $components = array('MyAuth');

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
	}

	function table() {
		$data = $this->paginate();
		$this->set(compact('data'));
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