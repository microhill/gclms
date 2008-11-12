<ul class="gclms-primary-column-menu">
	<?
	if(!empty($class)) {
		echo $this->element('class_menu');		
	} else if(!empty($course)) {
		echo $this->element('course_menu');
	} else if(Group::get('id')) {
		echo $this->element('group_menu');
	} else if(!empty($this->params['administration'])) {
		echo $this->element('super_admin_menu');
	} else {
		echo $this->element('menu', array("items" => array(
			array('controller' => 'Courses','class'=>'gclms-courses','label'=> __('Course Catalogue', true),'url'=>'/courses'),
			User::get('id') ? null : array('controller' => 'Register','class'=>'gclms-register','label'=> __('Register as New Student', true),'url'=>'/register'),
			Permission::check('*') ? array('controller'=>'administration','url' => '/administration','label'=>__('Site Administration', true),'class'=>'gclms-administration') : null
		)));
	}	
	
	/*
	if(array_search($this->name,array(
		'StudentCenter','Courses','Profile'
	)) !== false && empty($group)) {
		if(!empty($user))
			echo $this->element('user_menu');
		else
			echo $this->element('menu', array("items" => array(
				array('controller' => 'Courses','class'=>'gclms-courses','label'=> __('Course Catalogue', true),'url'=>'/courses'),
				array('controller' => 'Register','class'=>'gclms-register','label'=> __('Register as New Student', true),'url'=>'/register')
			)));
	}

	if(!empty($this->params['class'])) {
		echo $this->element('class_menu');
	} else if(!empty($this->params['course'])) {
		echo $this->element('course_menu');
	}
	
	if(!empty($course)) {

	} else if(array_search($this->name,array(
		'Groups','Configuration','Grading','Facilitators','Courses','Courses','Classes','Permissions'
	)) !== false && empty($this->params['administration']) && @$group) {
		echo $this->element('group_menu');
	} else if(!empty($this->params['administration'])) {
		echo $this->element('super_admin_menu');
	} else if(array_search($this->name,array(
		'StudentCenter','Courses','Profile'
	)) !== false && $user['super_administrator'] && empty($group))
		echo $this->element('menu', array('items' => array(
			
		)));
	*/
	?>
</ul>