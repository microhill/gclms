<?
class Book extends AppModel {
    var $belongsTo = array('Course');
    var $hasMany = array('Chapter');
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}