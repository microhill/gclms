<?
$menu->addMenu(array(
	'name' => 'course',
	'label' => __('Learn',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('course',array(
	'content' => __('Course Home', true),
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
	'label' => __('Interact',true),
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
	'name' => 'administration',
	'label' => __('Develop',true),
	'section' => 'primary_column'
));

1 ? $menu->addMenuItem('administration',array(
	'content' => __('Default Assignments', true),
	'class' => 'gclms-assignments',
	'active' =>  $this->name == 'Assignments',
	'url' => $groupAndCoursePath . '/assignments'
)) : null;

Permission::check('Content') ? $menu->addMenuItem('administration',array(
	'content' => __('Lesson Structure', true),
	'class' => 'gclms-course-content',
	'active' =>  $this->name == 'Content',
	'url' => $groupAndCoursePath . '/content'
)) : null;

Permission::check('Course') ? $menu->addMenuItem('administration',array(
	'content' => __('Configure Course', true),
	'class' => 'gclms-configuration',
	'active' =>  $this->name == 'Courses' && $this->action == 'edit',
	'url' => $groupAndCoursePath . '/configuration'
)) : null;

Permission::check('Course') ? $menu->addMenuItem('administration',array(
	'content' => __('Export Course', true),
	'class' => 'gclms-export',
	'active' =>  $this->name == 'Export',
	'url' => $groupAndCoursePath . '/export'
)) : null;