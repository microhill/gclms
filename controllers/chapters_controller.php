<?
class ChaptersController extends AppController {
    var $uses = array('Chapter','Book');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Chapter';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Books',$this->viewVars['groupAndCoursePath'] . '/books');
		parent::beforeRender();
	}

	function add() {
		if(empty($this->data['Chapter']['title']))
			return false;
		
		$lastChapterOrder = $this->Chapter->getLastOrderInBook($this->data['Chapter']['book_id']);

		$this->Chapter->save(array('Chapter'=>array(
			'book_id' => $this->data['Chapter']['book_id'],
			'title' => $this->data['Chapter']['title'],
			'order' => $lastChapterOrder + 1
		)));

		echo $this->Chapter->getLastInsertId();
		exit;
	}

    function rename($id) {
    	if(empty($this->data['Chapter']['title']))
			return false;
		
		$this->Chapter->id = $id;
    	$this->Chapter->saveField('title', $this->data['Chapter']['title']);
    	exit;
    }

	function reorder() {
		if(empty($this->data['Book']['chapters']))
			exit;

		$chapters = explode(',',$this->data['Book']['chapters']);

    	$order = 1;
    	foreach($chapters as $chapterId) {
    		$this->Chapter->id = $chapterId;
    		$this->Chapter->save(array('Chapter' => array(
				'book_id' => $this->data['Book']['id'],
				'order' => $order
			)));
    		$order++;
    	}

    	exit;
	}
	
	function toc($bookId) {
		$this->Book->contain();
		$book = $this->Book->findById($bookId);
		$this->set('book',$book);

		$this->Chapter->contain();
		$chapters = $this->Chapter->findAll(array('Chapter.book_id' => $bookId),array('id','title','order'),'Chapter.order ASC');
		$this->set(compact('chapters'));
	}

    function index() {
		die('Deprecated. Route to TOC.');
    }
	
	function delete($id) {
		$this->data = $this->Chapter->findById($id,array('book_id'));
		return parent::delete($id);
	}

	function afterSave() {
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/chapters/toc/' . $this->data['Chapter']['book_id']);
		exit;
	}

	function view($id) {
		$this->Chapter->contain();
		$chapter = $this->Chapter->findById($id);
		$this->set('chapter',$chapter);
	}
}