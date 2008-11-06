<?
class ClassesController extends AppController {
    var $uses = array('VirtualClass');
	//var $components = array('MyAuth');
	var $helpers = array('Paginator','MyPaginator','MyForm','Time','MyTime');
	var $paginate = array('order' => 'title');
	var $itemName = 'Class';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		if($this->action == 'index') {
			$this->Breadcrumbs->addCrumb('Classes','/' . Group::get('web_path') . '/classes');
		}
		parent::beforeRender();
	}
	
	function index() {
		$this->Permission->cache('Course','Permission','Group','VirtualClass');

		$this->VirtualClass->contain(array('Course' => array('id','title','web_path')));
		$classes = $this->VirtualClass->findAll(array('VirtualClass.group_id' => Group::get('id')));
		$this->data = array();
		$courses = array();
		
		foreach($classes as $class) {
			$this->data[$class['Course']['id']][] = $class['VirtualClass'];
			$courses[$class['Course']['id']] = $class['Course'];
		}
		$this->set('courses',$courses);
	}
	
	function add(){
		if(!empty($this->data)) {
			if($this->VirtualClass->save($this->data)) {
				$this->redirect('/' . Group::get('web_path') . '/classes');
			}
		}
		
		$this->set('courses',$this->Course->find('list'));
	}
	
	function edit($id = null) {
		$courses = $this->Course->findAll();
		$courses = array_combine(
			Set::extract($courses, '{n}.Course.id'),
			Set::extract($courses, '{n}.Course.title')
		);
		$this->set('courses',$courses);
		
		parent::edit($id);
	}

	/*
	function index_old() {
		$id = $this->params['class'];

		$this->Unit->contain();
		$units = $this->Unit->findAll(array("Unit.course_id" => $this->viewVars['course']['id']),null,'Unit.order ASC');
		$this->set(compact('units'));

		$this->Lesson->contain();
		$lessons = $this->Lesson->findAll(array("Lesson.course_id" => $this->viewVars['course']['id']),null,'Lesson.order ASC');
		$this->set(compact('lessons'));

		$this->Announcement->contain();
		$news_items = $this->Announcement->findAllByFacilitatedClassId($id);
		$this->set('news_items',$news_items);
		
		$this->set('title',$this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name') . ' &raquo; ' . Configure::read('App.name'));
	}
	*/
}