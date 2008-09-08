<?php
class ForumPost extends AppModel {
    var $belongsTo = array('Forum','User' => array(
		'fields' => array('id','alias','email')
	));
	
	var $hasMany = array('Reply' => array(
		'className'     => 'ForumPost',
		'foreignKey'    => 'parent_post_id',
		'order'    => 		'Reply.created ASC',
		'conditions'    => 'Reply.parent_post_id != 0',
		'dependent'=> true
	));
	
	function afterFind2($results,$primary = false) {
		if(!$primary)
			return $results;
		
		foreach($results as &$forum_post) {
			$forum_post['ForumPost']['reply_count'] = $this->find('count',array(
				'conditions' => array('ForumPost.origin_post_id' => $forum_post['ForumPost']['id'])
			));
		}
		
		return $results;
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'content' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}