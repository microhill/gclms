<?
class NotebookController extends AppController {
    var $uses = array('Notebook');
    var $components = array('RequestHandler');
    
	function edit() {
		if(!empty($this->data)) {
    		$this->Notebook->save($this->data['Notebook']);
    	} else {
			$this->Notebook->contain();		
			$notebook = $this->Notebook->find(array('Notebook.user_id' => $this->viewVars['user']['id'],'Notebook.course_id' => $this->viewVars['course']['id']));;
			if(empty($notebook)) {
				$this->Notebook->id = null;
				$this->Notebook->save(array(
					'user_id' => $this->viewVars['user']['id'],
					'course_id' => $this->viewVars['course']['id']
				));
				$notebook = $this->Notebook->find(array('Notebook.user_id' => $this->viewVars['user']['id'],'Notebook.course_id' => $this->viewVars['course']['id']));;
			}
			$this->data = $notebook;
		}		
		
		$this->render('edit','tabbed_viewport');
	}
	
    function index() {
    	$this->Notebook->contain();
    	$notebook = $this->Notebook->find(array('Notebook.user_id' => $this->viewVars['user']['id'],'Notebook.course_id' => $this->viewVars['course']['id']));

    	$this->data = $notebook;
    	
    	if(@$this->passedArgs['location'] == 'sidebar')
    		$this->render('bare','lesson');
    }
    
    function save() {
    	//$this->data['Notebook']
    	if(empty($this->data['Notebook']['id'])) {
			$this->data['Notebook']['user_id'] = $this->viewVars['user']['id'];
			$this->data['Notebook']['course_id'] = $this->viewVars['course']['id'];    		
    	}
		parent::save();
    }
        
    function afterSave() {
    	$this->redirect = $this->viewVars['groupAndCoursePath'] . '/notebook/section:' . $this->viewVars['course']['id'];
    	parent::afterSave();
    }
}