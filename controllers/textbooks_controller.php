<?
class TextbooksController extends AppController {
    var $uses = array('Textbook');
	var $helpers = array('Paginator','MyPaginator');
	var $itemName = 'Textbook ';
	var $paginate = array('order' => 'title');
	var $components = array('MyAuth');

	function add() {
		if(empty($this->data['Textbook']['title']))
			return false;

		$this->Textbook->save(array('Textbook'=>array(
			'course_id' => $this->viewVars['course']['id'],
			'title' => $this->data['Textbook']['title']
		)));

		echo $this->Textbook->getLastInsertId();
		exit;
	}
	
	function panel(){
		$this->Textbook->contain('Chapter');
		$textbooks = $this->Textbook->findAllByCourseId($this->viewVars['course']['id']);
		$this->set(compact('textbooks'));
		$this->render('show','classroom_panel');
	}

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Textbooks','/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']). '/textbooks';
		parent::beforeRender();
	}
	
	function index() {
		$this->Textbook->contain();
		$textbooks = $this->Textbook->findAll(array("Textbook.course_id" => $this->viewVars['course']['id']),null,'Textbook.title ASC');
		$this->set(compact('textbooks'));
	}

    function rename() {
    	$this->Textbook->id = $this->passedArgs['id'];
    	$this->Textbook->saveField('title', $this->data['Textbook']['title']);
    	exit;
    }

    function delete($id) {
    	$this->Textbook->delete($id);
    	exit;
    }

	function afterSave() {
		$this->redirect('/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path']) . '/textbooks';
	}
}