<?
class VirtualClass extends AppModel {
    var $recursive = 0;
	var $hasMany = array('ChatMessage','ChatParticipant','Announcement','ClassFacilitator');
    
    var $hasAndBelongsToMany = array(
		'Enrollee' =>
			array(
				'className'    => 'User',
				'joinTable'    => 'class_enrollees',
				'foreignKey'   => 'virtual_class_id',
				'associationForeignKey'=> 'user_id',
				'unique'       => true
			)
	);
    
    var $belongsTo = array('Course');

	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY,
			'duplicateUsername' => 'checkUsername'
		),
		'has_student_time_limit' => 'checkTimeLimit',
		'start' => 'checkStartDate',
		'end' => 'checkEndDate',
		'enrollment_deadline' => 'checkEnrollmentDeadline'
	);
	
	function inviteStudent($identifier) {
		$this->User =& ClassRegistry::init('User');
		$user = $this->User->identify($identifier);
		if($user) {
			if($this->addStudent($user['User']['id']))
				return true;
		} else if(strpos($identifier,'@') !== false) {
			//check to see if invitation has already been sent
			
			//mail person
			//mail($this->data['Student']['identifier'],springf(__('Invitation to %',true),VirtualClass::get('title')),__('You have been invited to %.',true));
			
			$this->ClassInvitation =& ClassRegistry::init('ClassInvitation');
			$this->ClassInvitation->save(array(
				'identifier' => $identifier,
				'virtual_class_id' => VirtualClass::get('id')
			));
			
			return true;
		}
		return false;
	}
	
	function addStudent($user_id) {
		$this->ClassEnrollee =& ClassRegistry::init('ClassEnrollee');
		if($this->ClassEnrollee->save(array(
			'virtual_class_id' => VirtualClass::get('id'),
			'user_id' => $user_id
		))) {
			return true;
		} else {
			return false;
		}
	}
	
	function afterSave($created) {
		if($created) {
			$this->Assignment =& ClassRegistry::init('Assignment');
			$assignments = $this->Assignment->find('all',array(
				'conditions' => array(
					'Assignment.course_id' => $this->data['VirtualClass']['course_id'],
					'Assignment.virtual_class_id' => null
				),
				'contain' => false
			));
			foreach($assignments as $assignment) {
				$sourceId = $assignment['Assignment']['id'];
				unset($assignment['Assignment']['id']);
				$assignment['Assignment']['virtual_class_id'] = $this->id;
				if(!$this->Assignment->create($assignment,true) || !$this->Assignment->saveAndCloneAssociations($sourceId))
					die('Error with afterSave');
			}
		}
	}
	
	function checkTitle() {
		if($this->find('first',array(
			'conditions' => array(
				'Course.group_id' => Group::get('id'),
				'VirtualClass.title' => $this->data['VirtualClass']['title']
			),
			'contain' => array('Course' => array('id','title','web_path'))
		)))
			return false;
		return true;
	}
	
	function checkStartDate() {
		if(empty($this->data['VirtualClass']['has_start_and_end_date'])) {
			$this->data['VirtualClass']['start'] = null;
		}
		return true;
	}
	
	function checkEndDate() {
		if(empty($this->data['VirtualClass']['has_start_and_end_date'])) {
			$this->data['VirtualClass']['end'] = null;
		} else {
			$this->data['VirtualClass']['has_time_limit'] = null;
			$this->data['VirtualClass']['time_limit'] = null;
		}
		return true;
	}
	
	function checkEnrollmentDeadline() {
		if(empty($this->data['VirtualClass']['has_enrollment_deadline'])) {
			$this->data['VirtualClass']['enrollment_deadline'] = null;
		}
		return true;
	}
	
	function checkTimeLimit() {
		if(empty($this->data['VirtualClass']['has_student_time_limit'])) {
			$this->data['VirtualClass']['time_limit_years'] = null;
			$this->data['VirtualClass']['time_limit_months'] = null;
			$this->data['VirtualClass']['time_limit_days'] = null;
		}
		return true;
	}
	
	function &getInstance($class = null) {
		static $instance = array();
		
		if($class) {
			$instance[0] =& $class;
		}
		
		if (!$instance) {
			return $instance;
		}
	
		return $instance[0];
	}
	
	function store($class) {
		VirtualClass::getInstance($class);
	}
	
	function get($path) {
		$_virtual_class =& VirtualClass::getInstance();
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'VirtualClass') !== 0) {
			$path = sprintf('VirtualClass/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}
		
		$value = Set::extract($path, $_virtual_class);
		
		if (!$value) {
			return null;
		}
		
		return $value[0];
	}
}