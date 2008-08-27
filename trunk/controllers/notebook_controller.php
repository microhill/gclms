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
	
	function edit() {
		if(!empty($this->data)) {
    		$this->NotebookEntry->save($this->data['NotebookEntry']);
    	} else {
			$this->NotebookEntry->contain();		
			$notebook = $this->NotebookEntry->find(array('NotebookEntry.user_id' => $this->viewVars['user']['id'],'NotebookEntry.course_id' => $this->viewVars['course']['id']));;
			if(empty($notebook)) {
				$this->NotebookEntry->id = null;
				$this->NotebookEntry->save(array(
					'user_id' => $this->viewVars['user']['id'],
					'course_id' => $this->viewVars['course']['id']
				));
				$notebook = $this->NotebookEntry->find(array('NotebookEntry.user_id' => $this->viewVars['user']['id'],'NotebookEntry.course_id' => $this->viewVars['course']['id']));;
			}
			$this->data = $notebook;
		}		
		
		$this->render('edit','tabbed_viewport');
	}
	
    function index() {
    	$this->NotebookEntry->contain();
    	$notebook = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => $this->viewVars['user']['id'],'NotebookEntry.course_id' => $this->viewVars['course']['id']),
			'order' => 'NotebookEntry.created DESC'
		));

    	$this->data = $notebook;
    }
    
    function save() {
    	//$this->data['NotebookEntry']
    	if(empty($this->data['NotebookEntry']['id'])) {
			$this->data['NotebookEntry']['user_id'] = $this->viewVars['user']['id'];
			$this->data['NotebookEntry']['course_id'] = $this->viewVars['course']['id'];    		
    	}
		parent::save();
    }
        
    function afterSave() {
    	$this->redirect = $this->viewVars['groupAndCoursePath'] . '/notebook/section:' . $this->viewVars['course']['id'];
    	parent::afterSave();
    }
}