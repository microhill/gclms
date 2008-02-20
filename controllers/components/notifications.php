<?
class NotificationsComponent extends Object {
	var $notifications = array();
    
    function startup(&$controller){
    	$this->controller = &$controller;
    }
    
	function add($text,$type = 'success') {
		$this->notifications[] = array(
			'text' => $text,
			'type' => $type
		);
		$this->controller->Session->write('Notifications.all',$this->notifications);
		
		return true;
	}
	function getAll() {
		if($this->controller->Session->check('Notifications.all')) {
			$notifications = $this->controller->Session->read('Notifications.all');
			$this->controller->Session->delete('Notifications.all');
			return $notifications;
		} else
			return array();		
	}
}