<?php
class ForumPost extends AppModel {
    var $belongsTo = array('Forum','User');
	
	var $hasMany = array('Reply' => array(
		'className'     => 'ForumPost',
		'foreignKey'    => 'parent_post_id',
		'order'    => 		'Reply.created ASC',
		'conditions'    => 'Reply.parent_post_id != 0',
		'dependent'=> true
	));
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'content' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}