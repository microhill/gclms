<?
class Assignment extends AppModel {
    var $belongsTo = array('Course','VirtualClass');
	var $hasMany = array('AssignmentAssociation');
	
	function beforeSave() {
		if(VirtualClass::get('id'))
			$this->data['Assignment']['course_id'] = Course::get('id');

		if(VirtualClass::get('id'))
			$this->data['Assignment']['virtual_class_id'] = VirtualClass::get('id');
		
		if(!empty($this->data['Assignment']['has_due_date'])) {
			$this->data['Assignment']['due_date'] = (((int) $this->data['Assignment']['due_date_week'] - 1) * 7) + (int) $this->data['Assignment']['due_date_day'] - 1;
		} else {
			$this->data['Assignment']['due_date'] = 0;
		}
		
		return true;
	}
	
	function saveAndCloneAssociations($sourceId) {
		$this->save();
		
		//$this->AssignmentAssociation =& ClassRegistry::init('AssignmentAssociation');
		$associations = $this->AssignmentAssociation->find('all',array(
			'conditions' => array('AssignmentAssociation.assignment_id' => $sourceId),
			'contain' => false
		));
		
		if(!empty($associations)) {
			foreach($associations as $association) {
				unset($association['AssignmentAssociation']['id']);
				$association['AssignmentAssociation']['assignment_id'] = $this->id;
				if(!$this->AssignmentAssociation->create($association,true) || !$this->AssignmentAssociation->save())
					die('Error with saveAndCloneAssociations');
			}
		}
		
		return true;
	}
	
	function afterSave($created) {
		$this->AssignmentAssociation =& ClassRegistry::init('AssignmentAssociation');

		if(!$created) {
			//Delete removed associations
			$existingAssociations = $this->AssignmentAssociation->find('all',array(
				'conditions' => array(
					'assignment_id' => $this->id
				),
				'fields' => array('id'),
				'contain' => false
			));
			$existingAssociationIds = Set::extract('/AssignmentAssociation/id',$existingAssociations);
			//pr($existingAssociationIds);
			$updatedAssociationsIds = array_keys($this->data['Assignment']['AssignmentAssociation']);
			//pr($updatedAssociationsIds);
			$associationsToDelete = array_diff($existingAssociationIds,$updatedAssociationsIds);
			//prd($associationsToDelete);
	
			$this->AssignmentAssociation->deleteAll(array(
				'AssignmentAssociation.id' => $associationsToDelete
			));	
		}
		
		if(!empty($this->data['Assignment']['AssignmentAssociation'])) {
			//Save updated associations with percentage
			foreach($this->data['Assignment']['AssignmentAssociation'] as $associatedObjectId => $associatedObject) {
				$this->AssignmentAssociation->id = $associatedObjectId;
				$associatedObject['assignment_id'] = $this->id;
				if((int) @$associatedObject['percentage_of_grade'] < 0 || (int) @$associatedObject['percentage_of_grade'] > 100 || empty($associatedObject['results_figured_into_grade']))
				$associatedObject['percentage_of_grade'] = 0;
				$this->AssignmentAssociation->save($associatedObject);
			}
		} else {
			$this->data['Assignment']['AssignmentAssociation'] = array();
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