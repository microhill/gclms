<?
class AssignmentAssociation extends AppModel {
    var $belongsTo = array('Assignment');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}