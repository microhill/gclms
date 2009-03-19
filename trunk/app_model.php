<?
class AppModel extends Model {
	var $validate = array(''=>'');
	//var $useDbConfig = 'test';
	var $actsAs = array('Containable');

	function generateEnumList($fieldName) {
		foreach($this->_tableInfo->value as $field) {
			if($field['name'] == $fieldName) {
				$enum = $field['type'];
				break;
			}
		}
		foreach(split("','", substr($enum, 6, -2)) as $num => $name) {
			$return[$name] = $name;
		}
		return $return;
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

	/*
	function beforeDelete() {
		$this->data = $this->read();
		if(@$this->data[$this->name]['deprecated'] == '0') {
			$this->saveField('deprecated','1');
			return false;
		}
		return true;
	}
	*/
	
	/*
	function beforeSave() { 
	    $this->useDbConfig = 'master'; 
	    return true;
	} 
	
	function afterSave() { 
	    $this->useDbConfig = 'default'; 
	    return true;
	} 
	
	function beforeDelete() { 
	    $this->useDbConfig = 'master'; 
	     return true;
	} 
	
	function afterDelete() { 
	    $this->useDbConfig = 'default'; 
	     return true;
	} 
	 

	function onError(&$model, $error) {
		pr($error);
	}*/
}