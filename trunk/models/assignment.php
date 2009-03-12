<?
class Assignment extends AppModel {
    var $belongsTo = array('Course','VirtualClass');
	var $hasMany = array('AssignmentAssociation');
	
	function beforeSave() {
		if(VirtualClass::get('id'))
			$this->data['Assignment']['course_id'] = Course::get('id');

		if(VirtualClass::get('id'))
			$this->data['Assignment']['virtual_class_id'] = VirtualClass::get('id');
		
		if(@$this->data['Assignment']['has_due_date']) {
			$this->data['Assignment']['due_date'] = (((int) $this->data['Assignment']['due_date_week'] - 1) * 7) + (int) $this->data['Assignment']['due_date_day'] - 1;
		}
		
		return true;
	}
	
	function afterSave($created) {
		$this->AssignmentAssociation =& ClassRegistry::init('AssignmentAssociation');
		if(!empty($this->data['Assignment']['AssociatedObject'])) {
			foreach($this->data['Assignment']['AssociatedObject'] as $associatedObjectId => $associatedObject) {
				$this->AssignmentAssociation->id = $associatedObjectId;
				$associatedObject['assignment_id'] = $this->id;
				if((int) $associatedObject['percentage_of_grade'] < 0 || (int) $associatedObject['percentage_of_grade'] > 100 || empty($associatedObject['results_figured_into_grade']))
				$associatedObject['percentage_of_grade'] = 0;
				$this->AssignmentAssociation->save($associatedObject);
			}
		}
	}
	
	function afterFind($results,$primary) {
		foreach($results as &$result) {
			if($result['Assignment']['due_date']) {
				$result['Assignment']['due_date_week'] = (int) ($result['Assignment']['due_date'] / 7) + 1;
				$result['Assignment']['due_date_day'] = ($result['Assignment']['due_date'] % 7) + 1;
			}
		}
		
		return $results;
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'type' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}