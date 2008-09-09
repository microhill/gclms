<?

uses('sanitize');

class ChatController extends AppController {
    var $uses = array('ChatMessage','ChatParticipant');
    var $helpers = array('Text');
    var $components = array('RequestHandler','Breadcrumbs'); //'MyAuth',
    
    function beforeFilter() {
		//$this->MyAuth->allowedActions = array('*');
       	
		parent::beforeFilter();
    }
    
    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
    	
    	parent::beforeRender();
    }
    
    function index() {
    	$this->ChatMessage->contain(array('User'=>array('alias','email')));
    	//$chat_messages = $this->ChatMessage->findAll(array('virtual_class_id' => $this->viewVars['class']['id']),null,'ChatMessage.created DESC',30);
		
		$chat_messages = $this->ChatMessage->find('all',array(
			'conditions' => array(
				'ChatMessage.course_id' => $this->viewVars['course']['id'],
				'ChatMessage.virtual_class_id' => @$this->viewVars['class']['id']
			),
			'order' => 'ChatMessage.created DESC',
			'limit' => 30
		));
    	$this->set('chat_messages',array_reverse($chat_messages));
    	
    	$chat_participants = $this->updateChatParticipants();
    	$this->set('chat_participants',$chat_participants);
    	
    	if(@$this->passedArgs['location'] == 'sidebar')
    		$this->render('bare','lesson_item');
    }
    
    function updateChatParticipants() {
		//Get chat participant record of current user
		$this->ChatParticipant->contain();
		$chat_participant = $this->ChatParticipant->find('first',array(
			'fields' => array('id'),
			'conditions' =>  array(
				'ChatParticipant.user_id'=> $this->viewVars['user']['id'],
				'ChatParticipant.course_id' => $this->viewVars['course']['id'],
				'ChatParticipant.virtual_class_id' => @$this->viewVars['class']['id']
		)));
		
		//If it exists, updated it; otherwise, create it
		if(!empty($chat_participant['ChatParticipant']['id'])) {
			$this->ChatParticipant->id = $chat_participant['ChatParticipant']['id'];
			$this->ChatParticipant->saveField('modified',date('Y-m-d H:i:s'));
		} else {
			$chat_participant = array('ChatParticipant' => array(
				'user_id' => $this->viewVars['user']['id'],
				'course_id' => $this->viewVars['course']['id'],
				'virtual_class_id' => @$this->viewVars['class']['id'],
				'modified' => date('Y-m-d H:i:s')));
			$this->ChatParticipant->save($chat_participant);
		}

		//Get most recent list of chat partipicants in room
		$this->ChatParticipant->contain(array('User.fields' => array('alias','email')));
		$chat_participants = $this->ChatParticipant->find('all',array(
			'conditions' => array(
				'course_id' => $this->viewVars['course']['id'],
				'virtual_class_id' => @$this->viewVars['class']['id']
		)));

		//Delete from list users who haven't pinged the server over a minute
		foreach($chat_participants as &$chat_participant) { 			
			if(strtotime('-1 minute') > strtotime($chat_participant['ChatParticipant']['modified'])) {
				$this->ChatParticipant->id = $chat_participant['ChatParticipant']['id'];
				$this->ChatParticipant->delete();
				$chat_participant = null;
			}
		}
		return $chat_participants;
    }
    
    function leave() {
    	$this->ChatParticipant->query('delete from chat_participants where user_id = ' . $this->viewVars['user']['id'] . ' AND virtual_class_id = ' . $this->viewVars['class']['id'] . ';');
    	exit;
    }
    
    function send() {
    	if(!$this->RequestHandler->isAjax())
    		die();
    		
    	$this->data['ChatMessage']['content'] = trim($this->data['ChatMessage']['content']);
    	if(empty($this->data['ChatMessage']['content']))
    		die();
    	
    	$data = array('ChatMessage' => array(
    		'user_id' => $this->viewVars['user']['id'],
    		'course_id' => $this->viewVars['course']['id'], 
			'virtual_class_id' => @$this->viewVars['class']['id'], 
			'content' => $this->data['ChatMessage']['content']
		));
    	$this->ChatMessage->save($data);
    	die();
    }
    
    function get() {
		$datetime = $this->data['latest_datetime'];
		
		//$mrClean = new Sanitize();
    	//$datetime = $mrClean->paranoid($datetime);
    	$datetime = date('Y-m-d H:i:s',$datetime);
    	
    	$this->ChatMessage->contain(array('User'=>array('alias')));
		$chat_messages = $this->ChatMessage->find('all',array(
			'conditions' => array(
				'ChatMessage.course_id' => $this->viewVars['course']['id'],
				'ChatMessage.virtual_class_id' => @$this->viewVars['class']['id'],
				'ChatMessage.created' => '> ' . $datetime,
				'ChatMessage.user_id' => '<> ' . $this->viewVars['user']['id']
			),
			'order' => 'ChatMessage.created DESC'
		));

    	foreach($chat_messages as &$chat_message) {
    		$chat_message['ChatMessage']['created'] = strtotime($chat_message['ChatMessage']['created']);
    	}
    	$this->set('chat_messages',$chat_messages);
    	
    	$chat_participants = array();
    	if(rand(1, 3) == 1) {
    		$chat_participants = $this->updateChatParticipants();
    	}
    	
    	$this->set('chat_participants',$chat_participants);
    }
}