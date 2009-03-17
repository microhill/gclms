<?
class ForumPostRead extends AppModel {
    var $belongsTo = array('Forum','User');
	
	var $validate = array(
		'forum_post_id' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'user_id' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}