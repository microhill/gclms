<?
class AssignmentAssociation extends AppModel {
    var $belongsTo = array('Assignment');
	
	var $validate = array(
		'assignment_id' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'description' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
	
	function afterFind($results,$primary = false) {
		foreach($results as &$result) {
			if(is_array($result)) {
				$result = $this->afterFind($result);
			}
			if(empty($result['AssignmentAssociation']['model']))
				return $results;
				
			$this->Node =& ClassRegistry::init('Node');
			$this->Forum =& ClassRegistry::init('Forum');

			if($result['AssignmentAssociation']['model'] == 'Page') {
				$node = $this->Node->find('first',array(
					'conditions' => array('Node.id' => $result['AssignmentAssociation']['foreign_key']),
					'contain' => array('Question' => 'id')
				));
				
				$result['AssignmentAssociation']['title'] = $node['Node']['title'];
				/*
				$result['AssignmentAssociation']['Page'] = array(
					'title' => $node['Node']['title']
				);
				*/
			} else if($result['AssignmentAssociation']['model'] == 'Forum') {
				$forum = $this->Forum->find('first',array(
					'conditions' => array('Forum.id' => $result['AssignmentAssociation']['foreign_key']),
					'contain' => false
				));
				$result['AssignmentAssociation']['title'] = $forum['Forum']['title'];
				/*
				$result['Forum'] = array(
					'title' => $forum['Forum']['title']
				);
				*/
			}
		}

		return $results;
	}
}