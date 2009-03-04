<?
class BooksController extends AppController {
    var $uses = array('Book');
	var $helpers = array('Menu');
	var $itemName = 'Book';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Permission->cache('GroupAdministration','Content');
	}

	function add() {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
		if(!empty($this->data)) {
			if($this->Book->save(array('Book'=>array(
				'course_id' => $this->viewVars['course']['id'],
				'title' => $this->data['Book']['title']
			))))			
				$this->afterSave();
		}
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Books','/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path']). '/books';
		parent::beforeRender();
	}
	
	function index() {
		$this->Book->contain('Chapter');
		$books = $this->Book->findAll(array("Book.course_id" => $this->viewVars['course']['id']),null,'Book.title ASC');
		$this->set(compact('books'));
		
		$this->set('title',__('Books',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));
	}

    function rename($id) {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
    	$this->Book->id = $id;
    	$this->Book->saveField('title', $this->data['Book']['title']);
    	exit;
    }

    function delete($id) {
		if(!Permission::check('Content')) {
			$this->cakeError('permission');
		}
		
    	$this->Book->delete($id);
    	exit;
    }
	
	function chapter($id) {
		App::import('Model','Chapter');
		$this->Chapter = new Chapter;
		
		$this->Chapter->contain();
		$chapter = $this->Chapter->findById($id);
		$this->set('chapter',$chapter);
		
		$this->set('title',$chapter['Chapter']['title'] . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name'));		
	}

	function afterSave() {
		$this->redirect('/' . Group::get('web_path') . '/' . $this->viewVars['course']['web_path'] . '/books');
	}
}