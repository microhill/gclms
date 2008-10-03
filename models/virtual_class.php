<?
class VirtualClass extends AppModel {
	var $hasMany = array('ChatMessage','ChatParticipant','Announcement');
    
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
    
    var $belongsTo = array('Course','Group');

	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY,
			'duplicateAlias' => 'checkAlias'
		),
		'has_student_time_limit' => 'checkTimeLimit',
		'start' => 'checkStartDate',
		'end' => 'checkEndDate',
		'enrollment_deadline' => 'checkEnrollmentDeadline'
	);
	
	function checkTitle() {
		if($this->findByGroupIdAndTitle($this->data['VirtualClass']['group_id'],$this->data['VirtualClass']['title']))
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
}