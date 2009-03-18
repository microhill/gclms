<?
class EnrollmentController extends AppController {
    var $uses = array('VirtualClass');
	var $helpers = array('Paginator','MyPaginator','MyForm','Time','MyTime','Menu');
	var $paginate = array('order' => 'title');

	function beforeFilter() {
		parent::beforeFilter();
		
		/*
		$this->Permission->cache('GroupAdministration');
		if(!Permission::check('Group')) {
			$this->cakeError('permission');
		}
		*/
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		if($this->action == 'index') {
			$this->Breadcrumbs->addCrumb('Classes','/' . Group::get('web_path') . '/classes');
		}
		parent::beforeRender();
	}
	
	function index() {
	}
	
}