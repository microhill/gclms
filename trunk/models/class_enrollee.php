<?
class ClassEnrollee extends AppModel {
    var $belongsTo = array('User','VirtualClass');
	
	var $validate = array(
		'user_id' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'virtual_class_id' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
	
	function beforeSave() {
		if(empty($this->data['ClassEnrollee']['approved'])) {
			//mail facilitators
			$this->ClassFacilitator =& ClassRegistry::init('ClassFacilitator');
			$facilitators = $this->ClassFacilitator->find(array(
				'conditions' => array(
					'virtual_class_id' => VirtualClass::get('id')
				)
			));
			
			foreach($facilitators as $facilitator) {
				prd($facilitator);
			}
		}
	}
}