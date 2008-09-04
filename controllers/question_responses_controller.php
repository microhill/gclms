<?
class QuestionResponsesController extends AppController {
    var $uses = array('QuestionResponse');

	function save_essay() {
		App::import('Model','NotebookEntry');
		$this->NotebookEntry = new NotebookEntry;
		
		if(empty($this->data['QuestionResponse']) || empty($this->data['QuestionResponse']['question_id']))
			die('No data.');
			
		$question_response = $this->QuestionResponse->find('first',array(
			'conditions' => array('QuestionResponse.user_id' => $this->viewVars['user']['id'],'QuestionResponse.question_id' => $this->data['QuestionResponse']['question_id']),
			'contain' => false
		));
		if(!empty($question_response['QuestionResponse']['id'])) {
			$this->QuestionResponse->id = $question_response['QuestionResponse']['id'];
		}

		$this->data['QuestionResponse']['user_id'] = $this->viewVars['user']['id'];
		if($this->QuestionResponse->save($this->data['QuestionResponse'])) {
			$notebook_entry = $this->NotebookEntry->find('first',array(
				'conditions' => array('NotebookEntry.user_id' => $this->viewVars['user']['id'],'NotebookEntry.question_id' => $this->data['QuestionResponse']['question_id']),
				'contain' => false
			));
			if(!empty($notebook_entry)) {
				$this->NotebookEntry->id = $notebook_entry['NotebookEntry']['id'];
			} else {
				$notebook_entry = array('NotebookEntry' => array(
					'user_id' => $this->viewVars['user']['id'],
					'course_id' => $this->viewVars['course']['id'],
					'question_id' => $this->data['QuestionResponse']['question_id']
				));
			}
			
			App::import('Model','Question');
			$this->Question = new Question;
			
			$title = $this->Question->field('title',array('Question.id' => $this->data['QuestionResponse']['question_id']));
			$notebook_entry['NotebookEntry']['title'] = $title;
			
			$this->NotebookEntry->save($notebook_entry);
			
			die('Successful');
		}
		die('Error');
	}
}