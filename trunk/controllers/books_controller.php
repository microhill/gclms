<?
class BooksController extends AppController {
    var $uses = array('Book');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Book ';
	var $paginate = array('order' => 'title');
	var $components = array('MyAuth');

	function add() {
		if(empty($this->data['Book']['title']))
			return false;

		$this->Book->save(array('Book'=>array(
			'course_id' => $this->viewVars['course']['id'],
			'title' => $this->data['Book']['title']
		)));

		echo $this->Book->getLastInsertId();
		exit;
	}
	
	function panel(){
		$this->Book->contain('Chapter');
		$books = $this->Book->findAllByCourseId($this->viewVars['course']['id']);
		$this->set(compact('books'));
		$this->render('show','classroom_panel');
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Books','/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']). '/books';
		parent::beforeRender();
	}
	
	function index() {
		$this->Book->contain();
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

	function afterSave() {
		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']) . '/books';
	}
}