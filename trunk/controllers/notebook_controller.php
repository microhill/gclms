<?
class NotebookController extends AppController {
    var $uses = array('NotebookEntry','NotebookEntryComment');
    var $components = array('RequestHandler');
	var $helpers = array('MyTime','Javascript');
	
    function index() {
    	$this->NotebookEntry->contain('NotebookEntryComment');
    	$entries = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => User::get('id')), // ,'NotebookEntry.course_id' => $this->viewVars['course']['id']
			//'limit' => 5
		));
		
		foreach($entries as &$entry) {
			$this->NotebookEntry->getQuestionResponse($entry,User::get('id'));
		}
	
		$this->set('entries',$entries);

    	$this->NotebookEntry->contain();
    	$archive = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => User::get('id')), //,'NotebookEntry.course_id' => $this->viewVars['course']['id']
			'order' => 'NotebookEntry.created ASC',
			'fields' => array('id','title','private','modified')
		));
    	$this->set('archive',$archive);
    }
	
	function view($id) {
    	$this->NotebookEntry->contain();
    	$archive = $this->NotebookEntry->find('all',array(
			'conditions' => array('NotebookEntry.user_id' => User::get('id')), //,'NotebookEntry.course_id' => $this->viewVars['course']['id']
			'order' => 'NotebookEntry.modified ASC'
		));
    	$this->set('archive',$archive);

    	$this->NotebookEntry->contain(array('NotebookEntryComment' => 'User'));
    	$this->data = $this->NotebookEntry->findById($id);
		$this->NotebookEntry->getQuestionResponse(&$this->data,User::get('id'));
	}
	
	function add_comment() {
		$this->data['NotebookEntryComment']['user_id'] = User::get('id');
		$this->NotebookEntryComment->save($this->data['NotebookEntryComment']);
		$this->redirect(Controller::referer());
	}
	
	function edit($id) {
		if(!empty($this->data)) {
			$this->data['NotebookEntry']['id'] = $id;
			
			$this->NotebookEntry->contain();
			$notebook_entry = $this->NotebookEntry->findById($id);
			if(!empty($notebook_entry['NotebookEntry']['question_id'])) {
				App::import('Model','QuestionResponse');
				$this->QuestionResponse = new QuestionResponse;
				$this->QuestionResponse->contain();
				$question_response = $this->QuestionResponse->find('first',array(
					'conditions' => array('QuestionResponse.user_id' => User::get('id'),'QuestionResponse.question_id' => $notebook_entry['NotebookEntry']['question_id'])
				));
				$this->QuestionResponse->id = $question_response['QuestionResponse']['id'];
				$this->QuestionResponse->saveField('answer',$this->data['NotebookEntry']['content']);
				$this->data['NotebookEntry']['content'] = '';
			}
			
			if($this->NotebookEntry->save($this->data))
				$this->redirect('/notebook/view/' . $id . $this->viewVars['framed_suffix']);
		}
		$this->data = $this->NotebookEntry->findById($id);
		$this->NotebookEntry->getQuestionResponse(&$this->data,User::get('id'));
	}
	
	function add() {
		if(!empty($this->data)) {
			$this->data['NotebookEntry']['user_id'] = User::get('id');
			if($this->NotebookEntry->save($this->data)) {
				$id = $this->NotebookEntry->id;
				$this->redirect('/notebook/view/' . $id . $this->viewVars['framed_suffix']);
			}
		}

		if(!empty($this->data) && $this->NotebookEntry->save($this->data)) {
			$this->redirect('/notebook' . $this->viewVars['framed_suffix']);
		}
	}
	
	function content() {
		$this->data = $this->NotebookEntry->field('content',array('NotebookEntry.id' => $this->data['NotebookEntry']['id']));
	}
}