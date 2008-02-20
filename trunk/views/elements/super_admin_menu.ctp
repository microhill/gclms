<?
echo $this->renderElement('menu', array("items" => array(
	array('label' => __('Groups', true), 'url' => '/administration/groups', 'class' => 'Groups',
		'active' => $this->name == 'Groups'),
	array('label' => __('Group Administrators', true), 'url' => '/administration/group_administrators', 'class' => 'group-administrators',
		'active' => $this->name == 'GroupAdministrators'),
	array('label' => __('Users', true), 'url' => '/administration/users', 'class' => 'Users',
		'active' => $this->name == 'Users'),
	array('label' => __('Plugins', true), 'url' => '/administration/plugins', 'class' => 'plugins',
		'active' => $this->name == 'Plugins')
)));