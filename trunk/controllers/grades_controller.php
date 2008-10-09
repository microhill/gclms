<?php
class GradesController extends AppController {
	var $uses = array('Grade');
	var $helpers = array('Paginator','MyPaginator');
	var $paginate = array('order' => 'email');
	
	function beforeFilter() {
		parent::beforeFilter();
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();

		parent::beforeRender();
	}

	function index() {
		$this->table();
	}
	
	function table() {
		$data = $this->paginate();
		$this->set(compact('data'));
	}
	
	function update_assessment() {
		if(!isset($this->passedArgs['page']) || !isset($this->passedArgs['grade'])
				 || !isset($this->passedArgs['maximum_possible']) || !isset($this->passedArgs['section']))
			die();
		
		$grade = $this->Grade->find(array('user_id' => User::get('id'), 'page_id' => $this->passedArgs['page']));
		if($grade)
			die();
			
		$this->Grade->save(array(
			'virtual_class_id' => $this->passedArgs['section'],
			'user_id' => User::get('id'),
			'grade' => $this->passedArgs['grade'],
			'maximum_possible' => $this->passedArgs['maximum_possible'],
			'page_id' => $this->passedArgs['page']
		));
		
		die();
	}
}