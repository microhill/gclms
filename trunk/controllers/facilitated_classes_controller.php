<?php
class FacilitatedClassesController extends AppController {
    var $uses = array('FacilitatedClass','Course','Group');
	var $helpers = array('Html','Form','MyForm','Paginator','MyPaginator','Time','MyTime');
	var $itemName = 'Class';
	var $paginate = array('order' => 'username');

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		
		$this->Breadcrumbs->addCrumb('Facilitated Classes','/' . Group::get('web_path') . '/virtual_classes');
		
		if($this->action == 'add' || $this->action == 'edit') {
			$this->set('courses',
				$this->Course->generateList('1=1', 'Course.title asc', null, '{n}.Course.id', '{n}.Course.name')
			);						
		}
		
		parent::beforeRender();
	}
	
	function add() {
		$this->set('available_courses',$this->Course->generateList(array('Course.group_id' => Group::get('id')),'Course.title ASC',null,'{n}.Course.id','{n}.Course.title'));
		
		parent::add();
	}
	
	function edit($id) {
		$this->set('available_courses',$this->Course->generateList(array('Course.group_id' => Group::get('id')),'Course.title ASC',null,'{n}.Course.id','{n}.Course.title'));
		
		parent::edit($id);
	}
	
	function afterSave() {
		$this->redirect('/' . Group::get('web_path') . '/virtual_classes');
	}

	function index() {
		if(Group::get('id')) {
			//$this->Lesson->unbindModel(array('belongsTo' => array('Course'),'hasMany' => array('Page')));
			//$lesson = $this->Lesson->find(array('Lesson.order' => $this->passedArgs['lesson'], 'Lesson.course_id' => $this->viewVars['course']['id']));
		
			$data = $this->paginate();
			$this->set(compact('data'));
		} else {
			$this->siteCatalogue();			
		}	
	}
	
	function siteCatalogue() {
		$data = $this->paginate();
		$this->set(compact('data'));
		$this->render('catalogue');
	}

}