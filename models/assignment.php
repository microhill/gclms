<?
class Assignment extends AppModel {
    var $belongsTo = array('Course','VirtualClass');
	
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
	
	function afterFind2($results,$primary) {
		//pr($results);
		foreach($results as &$result) {
			if($result['Assignment']['due_date']) {
				$result['Assignment']['due_date_week'] = (int) ($result['Assignment']['due_date'] / 7) + 1;
				$result['Assignment']['due_date_day'] = $result['Assignment']['due_date'] % 7;
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