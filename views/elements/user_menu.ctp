<?
$menu->addMenu(array(
	'name' => 'navigation',
	'title' => __('Navigation',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('navigation',array(
	'content' => __('Course Catalogue', true),
	'class' => 'gclms-courses',
	'active' => $this->name == 'Courses' && $this->action != 'index',
	'url' => '/courses'
));

$menu->addMenuItem('navigation',array(
	'content' => __('My Profile', true),
	'class' => 'gclms-profile',
	'active' => $this->name == 'Courses' && $this->action != 'index',
	'url' => '/profile'
));