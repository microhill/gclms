<?
class NotebookEntry extends AppModel {
	var $belongsTo = array('Course','User');
	var $hasMany = array('NotebookEntryComment');
	
	function beforeSave() {
		App::import('Vendor','HTMLPurifier',array('file'=>'htmlpurifier/HTMLPurifier.standalone.php'));
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML', 'Allowed', 'p,b,i,strong,em,ul,ol,li,blockquote');
			
		$purifier = new HTMLPurifier($config);
		
		$this->data['NotebookEntry']['title'] = $purifier->purify(strip_tags($this->data['NotebookEntry']['title'],'i,em'));
		$this->data['NotebookEntry']['content'] = $purifier->purify(@$this->data['NotebookEntry']['content']);
		
		return true;
	}
	
	function getQuestionResponse(&$entry,$user_id) {
		if(!empty($entry['NotebookEntry']['question_id']))	{
			if(!isset($this->QuestionResponse)) {
				App::import('Model','QuestionResponse');
				$this->QuestionResponse = new QuestionResponse;		
			}
			$entry['NotebookEntry']['content'] = $this->QuestionResponse->field('answer',array(
				'QuestionResponse.user_id' => $user_id,
				'QuestionResponse.question_id' => $entry['NotebookEntry']['question_id']
			));
		}
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'content' => array(
			//'rule' => VALID_NOT_EMPTY
		)
	);
}