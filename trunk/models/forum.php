<?php
class Forum extends AppModel {
    var $belongsTo = array('VirtualClass');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}