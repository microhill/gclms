<?
class Course extends AppModel {
    var $belongsTo = array('Group');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY,
			'message' => 'Title is required'
		),
		'web_path' => array(
			'titleAndPathEmpty' => 'checkWebPath',
			'duplicateWebPath' => array(
				'rule' => 'checkDuplicateWebPath',
				'on' => 'create',
				'message' => 'Path already used in group by another course')
		),
		/* 'description' => array(
			'rule' => VALID_NOT_EMPTY,
			'Description is required'
		) */
	);
	
	function checkWebPath() {
		if(empty($this->data['Course']['title']) && empty($this->data['Course']['web_path']))
			return false;
		
		if(!empty($this->data['Course']['web_path'])) {
			$this->data['Course']['web_path'] = stringToSlug($this->data['Course']['web_path']);
		} else {
			$this->data['Course']['web_path'] = stringToSlug($this->data['Course']['title']);		
		}
			
		//if($this->data['Course']['web_path'] != urlencode($this->data['Course']['web_path'])) 
		//	return false;
			
		return true;
	}
	
	function checkDuplicateWebPath() {
		if($this->findByGroupIdAndWebPath($this->data['Course']['group_id'],$this->data['Course']['web_path']))
			return false;
		return true;
	}
}