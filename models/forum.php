<?php
class Forum extends AppModel {
    var $belongsTo = array('FacilitatedClass');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}