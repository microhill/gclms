<?php

uses('sanitize');

class ChatController extends AppController {
    var $uses = array('ChatMessage','User','ChatParticipant');
    var $helpers = array('Text');
    var $components = array('MyAuth','RequestHandler','Breadcrumbs');
    
    function beforeFilter() {
		//$this->MyAuth->allowedActions = array('*');
       	
		parent::beforeFilter();
    }
    
    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
    	
    	parent::beforeRender();
    }
    
    function index() {
    	$this->ChatMessage->contain(array('User'=>array('first_name','last_name')));
    	$chat_messages = $this->ChatMessage->findAll(array('virtual_class_id' => $this->viewVars['virtual_class']['id']),null,'ChatMessage.created DESC',30);
    	$this->set('chat_messages',array_reverse($chat_messages));
    	
    	$chat_participants = $this->updateChatParticipants();
    	$this->set('chat_participants',$chat_participants);
    	
    	if(@$this->passedArgs['location'] == 'sidebar')
    		$this->render('bare','lesson_item');
    }
    
    function leave() {
    	$this->ChatParticipant->query('delete from chat_participants where user_id = ' . $this->viewVars['user']['id'] . ' AND virtual_class_id = ' . $this->viewVars['virtual_class']['id'] . ';');
    	exit;
    }
    
    function send() {
    	if(!$this->RequestHandler->isAjax())
    		die();
    		
    	$this->data['content'] = trim($this->data['content']);
    	if(empty($this->data['content']))
    		die();
    	
    	$data = array('ChatMessage' => array(
    		'user_id' => $this->viewVars['user']['id'],
    		'virtual_class_id' => $this->viewVars['virtual_class']['id'], 
			'content' => $this->data['content']
		));
    	$this->ChatMessage->save($data);
    	die();
    }
    
    function get($datetime) {
    	$mrClean = new Sanitize();
    	$datetime = $mrClean->paranoid($datetime);
    	$datetime = date('Y-m-d H:i:s',$datetime);
    	
    	$this->ChatMessage->contain(array('User'=>array('first_name','last_name')));
    	$chat_messages = $this->ChatMessage->findAll(
    		array(
				'ChatMessage.virtual_class_id' => $this->viewVars['virtual_class']['id'],
				'ChatMessage.created' => '> ' . $datetime,
				'ChatMessage.user_id' => '<> ' . $this->viewVars['user']['id']
			), null,'ChatMessage.created DESC');
    	foreach($chat_messages as &$chat_message) {
    		$chat_message['ChatMessage']['created'] = strtotime($chat_message['ChatMessage']['created']);
    	}
    	$this->set('chat_messages',$chat_messages);
    	
    	$chat_participants = array();
    	if(rand(1, 3) == 1) {
    		$chat_participants = $this->updateChatParticipants();
    	}
    	
    	$this->set('chat_participants',$chat_participants);
    	
    	$this->render('get','json');
    }
    
    function updateChatParticipants() {
		$this->ChatParticipant->contain();
		$chat_participant = $this->ChatParticipant->find(array('user_id'=>$this->viewVars['user']['id'],'virtual_class_id'=>$this->viewVars['virtual_class']['id']),array('id'));
		if(isset($chat_participant['ChatParticipant']['id'])) {
			$this->ChatParticipant->id = $chat_participant['ChatParticipant']['id'];
			$this->ChatParticipant->saveField('modified',date('Y-m-d H:i:s'));
		} else {
			$chat_participant = array('ChatParticipant' => array('user_id'=>$this->viewVars['user']['id'],'virtual_class_id'=>$this->viewVars['virtual_class']['id'],'modified'=>date('Y-m-d H:i:s')));
			$this->ChatParticipant->save($chat_participant);
		}

		$this->ChatParticipant->contain(array('User.fields' => array('first_name','last_name')));
		$chat_participants = $this->ChatParticipant->findAll(array('virtual_class_id'=>$this->viewVars['virtual_class']['id']));

		foreach($chat_participants as &$chat_participant) { 			
			if(strtotime('-1 minute') > strtotime($chat_participant['ChatParticipant']['modified'])) {
				$this->ChatParticipant->id = $chat_participant['ChatParticipant']['id'];
				$this->ChatParticipant->del();
				$chat_participant = null;
				$this->log($chat_participants);
			}
		}
		
		return $chat_participants;
    }
}