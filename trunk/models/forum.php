<?php
class Forum extends AppModel {
    var $belongsTo = array('Course','VirtualClass');
	var $hasMany = array('ForumPost');
	/*
	var $hasOne = array('LastPost' => array(
		'className' => 'ForumPost',
		'order' => 'LastPost.created ASC',
		'fields' => array('created','user_id')
	));
	*/
	
	function afterFind($results,$primary = false) {
		if(!$primary)
			return $results;
			
		foreach($results as &$forum) {
			$forum['Forum']['topic_count'] = $this->ForumPost->find('count',array(
				'conditions' => array('ForumPost.forum_id' => $forum['Forum']['id'],'ForumPost.parent_post_id' => '')
			));
			$forum['Forum']['post_count'] = $this->ForumPost->find('count',array(
				'conditions' => array('ForumPost.forum_id' => $forum['Forum']['id'])
			));
		}
		
		return $results;
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}