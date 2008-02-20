<?php
class Course extends AppModel {
    var $belongsTo = array('Group');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'web_path' => array(
			'titleAndPathEmpty' => 'checkWebPath',
			'duplicateWebPath' => array('rule' => 'checkDuplicateWebPath','on' => 'create')
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
	
	function checkWebPath() {
		if(empty($this->data['Course']['title']) && empty($this->data['Course']['web_path']))
			return false;
		
		if(!empty($this->data['Course']['web_path']))
			$this->data['Course']['web_path'] = stringToSlug($this->data['Course']['web_path']);
		else
			$this->data['Course']['web_path'] = stringToSlug($this->data['Course']['title']);
			
		return true;
	}
	
	function checkDuplicateWebPath() {
		if($this->findByGroupIdAndWebPath($this->data['Course']['group_id'],$this->data['Course']['web_path']))
			return false;
		return true;
	}
}