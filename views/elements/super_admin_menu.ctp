<?
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