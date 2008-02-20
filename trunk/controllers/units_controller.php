<?php
uses('Sanitize');

class UnitsController extends AppController {
    var $uses = array('Unit');
	var $itemName = 'Unit';
    		
    function add() {
		$title = $this->data['Unit']['title'];

		if(empty($title))
			return false;
		$lastUnitOrder = $this->Unit->getLastOrderInCourse($this->viewVars['course']['id']);
		
		if(ini_get('magic_quotes_gpc') == 1)
			$title = stripslashes($title);
		$title = Sanitize::stripTags($title); 

    	$this->Unit->save(array('Unit'=>array(
			'title' => $title,
			'course_id' => $this->viewVars['course']['id'],
			'order' => $lastUnitOrder + 1
		)));
		echo $this->Unit->getLastInsertId();
		exit;
    }
    
    function rename($id) {
    	$this->Unit->id = $id;
    	$title = $this->data['Unit']['title'];
		if(ini_get('magic_quotes_gpc') == 1)
			$title = stripslashes($title);
		$title = Sanitize::stripTags($title);
    	$this->Unit->saveField('title', $title);
    	exit;
    }
    
    function reorder() {
    	$units = explode(',',$this->data['Course']['units']);
    	
    	$order = 1;
    	foreach($units as $unitId) {
    		$this->Unit->id = $unitId;
    		$this->Unit->save(array('Unit' => array('order' => $order)));
    		$order++;
    	}    	
    	
    	exit;
    }
    
    function delete($id) {
    	$this->Unit->delete($id);
    	exit;
    }
}