<?
class BooksController extends AppController {
    var $uses = array('Book');
	var $itemName = 'Book';

	function add() {
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
		$this->Breadcrumbs->addCrumb('Books','/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']). '/books';
		parent::beforeRender();
	}
	
	function index() {
		$this->Book->contain('Chapter');
		$books = $this->Book->findAll(array("Book.course_id" => $this->viewVars['course']['id']),null,'Book.title ASC');
		$this->set(compact('books'));
		
		$this->set('title',__('Books',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
	}

    function rename($id) {
    	$this->Book->id = $id;
    	$this->Book->saveField('title', $this->data['Book']['title']);
    	exit;
    }

    function delete($id) {
    	$this->Book->delete($id);
    	exit;
    }
	
	function chapter($id) {
		App::import('Model','Chapter');
		$this->Chapter = new Chapter;
		
		$this->Chapter->contain();
		$chapter = $this->Chapter->findById($id);
		$this->set('chapter',$chapter);
		
		$this->set('title',$chapter['Chapter']['title'] . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);		
	}

	function afterSave() {
		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/books');
	}
}