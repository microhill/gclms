<?
/*
echo $this->element('menu', array("items" => array(
	array('label' => __('Statistics', true), 'url' => '/administration/statistics', 'class' => 'gclms-statistics',
		'active' => $this->name == 'Statistics'),
	array('label' => __('Groups', true), 'url' => '/administration/groups', 'class' => 'gclms-groups',
		'active' => $this->name == 'Groups'),
	array('label' => __('Administrators', true), 'url' => '/administration/administrators', 'class' => 'gclms-group-administrators',
		'active' => $this->name == 'Administrators'),
	array('label' => __('Users', true), 'url' => '/administration/users', 'class' => 'gclms-users',
		'active' => $this->name == 'Users')
)));
*/

$menu->addMenu(array(
	'name' => 'site_administration',
	'label' => __('Site Administration',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('site_administration',array(
	'content' => __('Statistics', true),
	'class' => 'gclms-statistics',
	'active' => $this->name == 'Statistics',
	'url' => '/administration/statistics'
));

$menu->addMenuItem('site_administration',array(
	'content' => __('Groups', true),
	'class' => 'gclms-groups',
	'active' => $this->name == 'Groups',
	'url' => '/administration/groups'
));

$menu->addMenuItem('site_administration',array(
	'content' => __('Administrators', true),
	'class' => 'gclms-users',
	'active' => $this->name == 'Administrators',
	'url' => '/administration/administrators'
));

$menu->addMenuItem('site_administration',array(
	'content' => __('Users', true),
	'class' => 'gclms-users',
	'active' => $this->name == 'Users',
	'url' => '/administration/users'
));