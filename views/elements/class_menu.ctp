<!--ul class="gclms-primary-column-menu"-->
	<?
	
	/*
	// If a facilitator
	echo $this->element('menu', array("items" => array(
		array('label' => __('Announcements', true), 'class' => 'gclms-announcements', 'active' => $this->name == 'Announcements2', 'url' => $groupAndCoursePath . '/announcements')
	)));
	*/
	
	/*
	$menu1 = array(
		array('label' => __('Home', true), 'class' => 'gclms-home', 'active' => $this->name == 'Announcements', 'url' => $groupAndCoursePath),
		array('label' => __('Books', true), 'class' => 'gclms-books', 'active' => $this->name == 'Books' || $this->name == 'Chapters', 'url' => $groupAndCoursePath . '/books'),
		array('label' => __('Articles', true), 'class' => 'gclms-articles', 'active' => $this->name == 'Articles', 'url' => $groupAndCoursePath . '/articles'),
		array('label' => __('Glossary', true), 'class' => 'gclms-glossary', 'active' => $this->name == 'Glossary', 'url' => $groupAndCoursePath . '/glossary'),
		array('controller' => 'Notebook', 'label' => __('Notebook', true), 'class' => 'gclms-notebook', 'url' => $groupAndCoursePath . '/notebook'),
		array('label' => __('Forums', true), 'class' => 'gclms-forums', 'active' => $this->name == 'Forums', 'url' => $groupAndCoursePath . '/forums'),
		array('label' => __('Chat', true), 'class' => 'gclms-chat', 'active' => $this->name == 'Chat', 'url' => $groupAndCoursePath . '/chat'),
		//array('label' => __('Configure Class', true), 'class' => 'gclms-configuration', 'active' => $this->name == 'Courses' && $this->action == 'edit', 'url' => $groupAndCoursePath . '/configuration')
	);
	
	$menu2 = array(
		array('label' => __('Assignments', true), 'class' => 'gclms-assignments', 'active' => $this->name == 'Assignments', 'url' => $groupAndCoursePath . '/assignments'),
		array('controller' => 'Grades', 'label' => __('Grades', true), 'url' => $groupAndCoursePath . '/grades'),	
	);
	*/
	
/*
echo $this->element('block',array(
	'title' => __('Course',true),
	'content' => '<ul>' . $this->element('menu', array("items" => $menu1)) . '</ul>'
));

echo $this->element('block',array(
	'title' => __('Facilitator',true),
	'content' => '<ul>' . $this->element('menu', array("items" => $menu2)) . '</ul>'
));
*/

$menu->addMenu(array(
	'name' => 'course',
	'title' => __('Learn',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('course',array(
	'content' => __('Class Home', true),
	'class' => 'gclms-home',
	'active' => $this->name == 'Courses' && $this->action != 'edit',
	'url' => $groupAndCoursePath
));

$menu->addMenuItem('course',array(
	'content' => __('Glossary', true),
	'class' => 'gclms-glossary',
	'active' =>  $this->name == 'Glossary',
	'url' => $groupAndCoursePath . '/glossary'
));

Permission::check('Course') ? $menu->addMenuItem('course',array(
	'content' => __('Files', true),
	'class' => 'gclms-files',
	'active' =>  $this->name == 'Files',
	'url' => $groupAndCoursePath . '/files'
)) : null;

$menu->addMenuItem('course',array(
	'content' => __('Articles', true),
	'class' => 'gclms-articles',
	'active' =>  $this->name == 'Articles',
	'url' => $groupAndCoursePath . '/articles'
));

$menu->addMenuItem('course',array(
	'content' => __('Books', true),
	'class' => 'gclms-books',
	'active' =>  $this->name == 'Books' || $this->name == 'Chapters',
	'url' => $groupAndCoursePath . '/books'
));

$menu->addMenu(array(
	'name' => 'interaction',
	'title' => __('Interact',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('interaction',array(
	'content' => __('Forums', true),
	'class' => 'gclms-forums',
	'active' => $this->name == 'Forums',
	'url' => $groupAndCoursePath . '/forums'
));

$menu->addMenuItem('interaction',array(
	'content' => __('Chat', true),
	'class' => 'gclms-chat',
	'active' => $this->name == 'Chat',
	'url' => $groupAndCoursePath . '/chat'
));

$menu->addMenu(array(
	'name' => 'facilitation',
	'title' => __('Facilitate',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('facilitation',array(
	'content' => __('Assignments', true),
	'class' => 'gclms-assignments',
	'active' =>  $this->name == 'Assignments',
	'url' => $groupAndCoursePath . '/assignments'
));

$menu->addMenuItem('facilitation',array(
	'content' => __('Gradebook', true),
	'class' => 'gclms-gradebook',
	'active' =>  $this->name == 'Gradebook',
	'url' => $groupAndCoursePath . '/gradebook'
));

$menu->addMenuItem('facilitation',array(
	'content' => __('Announcements', true),
	'class' => 'gclms-announcements',
	'active' =>  $this->name == 'Announcements',
	'url' => $groupAndCoursePath . '/announcements'
));

$menu->addMenuItem('facilitation',array(
	'content' => __('Students', true),
	'class' => 'gclms-users',
	'active' =>  $this->name == 'Students',
	'url' => $groupAndCoursePath . '/students'
));