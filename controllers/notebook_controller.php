<?
class NotebookController extends AppController {
    var $uses = array('NotebookEntry','NotebookEntryComment');
    var $components = array('RequestHandler');
	var $helpers = array('MyTime','Javascript');
	
	function view($id) {
    	$this->NotebookEntry->contain();
    	$archive = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => $this->viewVars['user']['id']), //,'NotebookEntry.course_id' => $this->viewVars['course']['id']
			'order' => 'NotebookEntry.modified ASC',
			'fields' => array('id','title','modified')
		));
    	$this->set('archive',$archive);

    	$this->NotebookEntry->contain(array('NotebookEntryComment' => 'User'));
    	$this->data = $this->NotebookEntry->findById($id);
	}
	
	function add_comment() {
		$this->data['NotebookEntryComment']['user_id'] = $this->viewVars['user']['id'];
		$this->NotebookEntryComment->save($this->data['NotebookEntryComment']);
		$this->redirect(Controller::referer());
	}
	
	function edit($id) {
		
	}
	
	function add() {
		if(!empty($this->data) && $this->NotebookEntry->save($this->data)) {
			$this->redirect('/notebook');
		}
	}
	
	function content() {
		$this->data = $this->NotebookEntry->field('content',array('NotebookEntry.id' => $this->data['NotebookEntry']['id']));
	}
	
    function index() {

		
    	$entries = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => $this->viewVars['user']['id']), // ,'NotebookEntry.course_id' => $this->viewVars['course']['id']
			'order' => 'NotebookEntry.modified ASC',
			'fields' => array('id','title','modified','content'),
			'limit' => 5
		));

    	$this->set('entries',$entries);
    }
}