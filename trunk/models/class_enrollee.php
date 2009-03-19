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
	
	function store($class) {
		ClassEnrollee::getInstance($class);
	}
	
	function get($path) {
		$_class_enrollee =& ClassEnrollee::getInstance();
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'ClassEnrollee') !== 0) {
			$path = sprintf('ClassEnrollee/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}
		
		$value = Set::extract($path, $_class_enrollee);
		
		if (!$value) {
			return null;
		}
		
		return $value[0];
	}
}