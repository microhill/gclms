<?
class GlossaryTerm extends AppModel {
    var $belongsTo = array('Course');
	
	var $validate = array(
		'term' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}