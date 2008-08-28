<?
class NotebookController extends AppController {
    var $uses = array('NotebookEntry');
    var $components = array('RequestHandler');
	var $helpers = array('MyTime','Javascript');
    
	function add() {
		$this->RequestHandler->setContent('json', 'text/x-json');
		
		$this->data['NotebookEntry']['course_id'] = $this->viewVars['course']['id'];
		$this->data['NotebookEntry']['user_id'] = $this->viewVars['user']['id'];
		$this->NotebookEntry->save($this->data['NotebookEntry']);
		$this->NotebookEntry->contain();
		$this->set('entry',$this->NotebookEntry->read());
		$this->render('add','default');
	}
	
	function content() {
		$this->data = $this->NotebookEntry->field('content',array('NotebookEntry.id' => $this->data['NotebookEntry']['id']));
	}
	
    function index() {
    	$this->NotebookEntry->contain();
    	$notebook = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => $this->viewVars['user']['id'],'NotebookEntry.course_id' => $this->viewVars['course']['id']),
			'order' => 'NotebookEntry.created DESC',
			'fields' => array('id','title','modified')
		));

    	$this->data = $notebook;
    }
}