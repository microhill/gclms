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
}