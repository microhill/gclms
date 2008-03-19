<ul class="gclms-left-column-menu">
	<?
	if(array_search($this->name,array(
		'StudentCenter','Courses','Profile'
	)) !== false && empty($group)) {
		if(!empty($user))
			echo $this->renderElement('user_menu');
		else
			echo $this->renderElement('menu', array("items" => array(
				array('controller' => 'Courses','label'=> __('Course Catalogue', true),'url'=>'/courses'),
				array('controller' => 'Register','label'=> __('Register as New Student', true),'url'=>'/register')
			)));
	}

//	

	if(!empty($this->params['class'])) {
		echo $this->renderElement('class_menu');
	} else if(!empty($this->params['course'])) {
		echo $this->renderElement('course_menu');
	}

	if(!empty($lesson)) {
	
	} else if(!empty($test)) {

	} if(!empty($course)) {

	} else if(array_search($this->name,array(
		'Groups','Configuration','Grading','Facilitators','Courses','Courses','FacilitatedClasses'
	)) !== false && empty($this->params['administration']) && @$group) {
		echo $this->renderElement('group_menu');
	} else if(!empty($this->params['administration'])) {
		echo $this->renderElement('super_admin_menu');
	} else if(array_search($this->name,array(
		'StudentCenter','Courses','Profile'
	)) !== false && $user['super_administrator'] && empty($group))
		echo $this->renderElement('menu', array('items' => array(
			array('controller'=>'administration','url' => '/administration/panel','label'=>__('Site Administration', true),'class'=>'gclms-administration')
		)));
	?>
</ul>