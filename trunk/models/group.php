<?
class Group extends AppModel {
    var $hasAndBelongsToMany = array(
		'GroupAdministrators' =>
			array(
				'className'   	=> 'User',
		    	'joinTable'   	=> 'group_administrators',
		        'foreignKey'  	=> 'group_id',
		        'associationForeignKey'=> 'user_id',
		        'unique'      	=> true,
		        'fields'		=> array('id','email','first_name','last_name','email')
			)
    );	

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
}