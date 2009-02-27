<?
class ClassInvitation extends AppModel {
    var $belongsTo = array('VirtualClass');
	
	var $validate = array(
		'virtual_class_id' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}