<?php
class Forum extends AppModel {
    var $belongsTo = array('Course','VirtualClass');
	var $hasMany = array('ForumPost');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}