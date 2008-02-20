<?php
class Article extends AppModel {
    var $belongsTo = array('Course');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}