<?
class ChaptersController extends AppController {
    var $uses = array('Chapter','Textbook');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Chapter';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Textbooks',$this->viewVars['groupAndCoursePath'] . '/textbooks');
		parent::beforeRender();
	}

	function add() {
		if(empty($this->data['Chapter']['title']))
			return false;
		
		$lastChapterOrder = $this->Chapter->getLastOrderInTextbook($this->data['Chapter']['textbook_id']);

		$this->Chapter->save(array('Chapter'=>array(
			'textbook_id' => $this->data['Chapter']['textbook_id'],
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
		if(empty($this->data['Textbook']['chapters']))
			exit;

		$chapters = explode(',',$this->data['Textbook']['chapters']);

    	$order = 1;
    	foreach($chapters as $chapterId) {
    		$this->Chapter->id = $chapterId;
    		$this->Chapter->save(array('Chapter' => array(
				'textbook_id' => $this->data['Textbook']['id'],
				'order' => $order
			)));
    		$order++;
    	}

    	exit;
	}
	
	function toc($textbookId) {
		$this->Textbook->contain();
		$textbook = $this->Textbook->findById($textbookId);
		$this->set('textbook',$textbook);

		$this->Chapter->contain();
		$chapters = $this->Chapter->findAll(array('Chapter.textbook_id' => $textbookId),array('id','title','order'),'Chapter.order ASC');
		$this->set(compact('chapters'));
	}

    function index() {
		die('Deprecated. Route to TOC.');
    }
	
	function delete($id) {
		$this->data = $this->Chapter->findById($id,array('textbook_id'));
		return parent::delete($id);
	}

	function afterSave() {
		$this->redirect($this->viewVars['groupAndCoursePath'] . '/chapters/toc/' . $this->data['Chapter']['textbook_id']);
		exit;
	}

	function view($id) {
		$this->Chapter->contain();
		$chapter = $this->Chapter->findById($id);
		$this->set('chapter',$chapter);
		$this->render('view','classroom_panel');
	}
}