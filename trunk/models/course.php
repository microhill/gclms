<?
class Course extends AppModel {
    var $recursive = 0;	
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
	
	function findLatestPublished($limit = 5) {
		return $this->find('all',array(
			'order' => 'Course.created DESC',
			'limit' => $limit,
			'contain' => array('Group' => array('web_path'))
		));
	}
	
	function &getInstance($course = null) {
		static $instance = array();
		
		if($course) {
			$instance[0] =& $course;
		}
		
		if (!$instance) {
			return $instance;
		}
	
		return $instance[0];
	}
	
	function store($course) {
		Course::getInstance($course);
	}
	
	function get($path) {
		$_course =& Course::getInstance();
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'Course') !== 0) {
			$path = sprintf('Course/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}
		
		$value = Set::extract($path, $_course);
		
		if (!$value) {
			return null;
		}
		
		return $value[0];
	}
}