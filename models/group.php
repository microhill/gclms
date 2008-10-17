<?
class Group extends AppModel {
    var $recursive = 0;

	var $hasMany = array('Course');

	var $validate = array(
		'web_path' => array(
			'rule' => 'validWebPath',
			'message' => 'Not a valid group name'
		),
		'name' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'logo' => array(
			'rule' => 'validLogo'
		)
	);
	
	function validWebPath() {
		if(empty($this->data['Group']['web_path']) || $this->data['Group']['web_path'] == 'test') {
			return false;
		}
		return true;
	}
	
	function generateList() {
		$groups = $this->findAll(null,array('id','name'),'Group.name ASC');
		return array_combine(
			Set::extract($groups, '{n}.Group.id'),
			Set::extract($groups, '{n}.Group.name')
		);
	}
	
	function beforeSave() {
		if(!empty($this->data['Group']['logo']['tmp_name'])) {
			$saveAs = ROOT . DS . APP_DIR . DS . 'files' . DS . 'logos' . DS . $this->id . '.img';
			move_uploaded_file($this->data['Group']['logo']['tmp_name'], $saveAs);
			$this->data['Group']['logo'] = $this->data['Group']['logo']['name'];
		} else if(empty($this->data['Group']['clear_logo'])) {
			unset($this->data['Group']['logo']);
		} else {
			$this->data['Group']['logo'] = '';
		}
		
		return true;
	}
	
	function validLogo() {
		if(empty($this->data['Group']['logo']['name'])) {
			unset($this->data['Group']['logo']);
			return true;
		}

		//Check for errors
		if(!empty($this->data['Group']['logo']['error']))
			return false;

		//Check for valid extension
		$path_parts = pathinfo($this->data['Group']['logo']['name']);
		if(!in_array($path_parts['extension'],array('jpg','jpeg','png','gif')))
			return false;

		//Check for valid mime type
		if(!in_array($this->data['Group']['logo']['type'],array('image/png', 'image/jpeg', 'image/pjpeg', 'image/gif')))
			return false;

		return true;
	}
	
	function findLatestParticipating($limit = 5) {
		return $this->find('all',array(
			'order' => 'Group.created DESC',
			'limit' => $limit,
			'contain' => false
		));
	}
	
	function &getInstance($group = null) {
		static $instance = array();
		
		if($group) {
			$instance[0] =& $group;
		}
		
		if (!$instance) {
			return $instance;
		}
	
		return $instance[0];
	}
	
	function store($group) {
		Group::getInstance($group);
	}
	
	function get($path) {
		$_group =& Group::getInstance();
		
		$path = str_replace('.', '/', $path);
		if (strpos($path, 'Group') !== 0) {
			$path = sprintf('Group/%s', $path);
		}
		
		if (strpos($path, '/') !== 0) {
			$path = sprintf('/%s', $path);
		}

		$value = Set::extract($path, $_group);
		
		if (!$value) {
			return false;
		}
		
		return $value[0];
	}
}