<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

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

Permission::check('SiteAdministration') ? $menu->addMenuItem('navigation',array(
	'content' => __('Site Administration', true),
	'class' => 'gclms-administration',
	'url' => '/administration'
)) : null;