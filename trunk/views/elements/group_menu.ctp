<?
// $this->element('menu', array("items" => array(
//	array('label' => __('Group Home', true),'class' => 'gclms-home', 'controller' => null, 'url' => '/' . $this->params['group'], 'active' => $this->viewPath == 'groups' && count($this->params['pass']) == 0),
//	Permission::check('VirtualClass') ? array('controller' => 'FacilitatedClasses', 'class' => 'gclms-courses', 'label' => __('Classes', true),'url'=>'/' . $this->params['group'] . '/classes', 'active' => $this->viewPath == 'classes') : null,
//	Permission::check('Permission') ? array('controller' => 'User Permissions','class'=>'gclms-facilitators','url' => '/' . Group::get('web_path') . '/permissions', 'active' => $this->viewPath == 'permissions') : null,
//	Permission::check('Course') ? array('controller' => 'Courses','label' => __('Add Course', true),'class' => 'gclms-add','url' => '/' . Group::get('web_path') . '/courses/add') : null,
//	Permission::check('Group') ? array('controller' => 'Configuration', 'class'=>'gclms-configuration','label' => __('Configure Group', true),'url' => '/' . Group::get('web_path') . '/configuration') : null
//)));

$menu->addMenu(array(
	'name' => 'group',
	'title' => __('Learn',true),
	'section' => 'primary_column'
));

$menu->addMenuItem('group',array(
	'content' => __('Group Home', true),
	'class' => 'gclms-home',
	'active' => $this->viewPath == 'groups' && count($this->params['pass']) == 0,
	'url' => '/' . $this->params['group']
));

if(Permission::check('VirtualClass'))
	$menu->addMenuItem('group',array(
		'content' => __('Classes', true),
		'class' => 'gclms-courses',
		'active' => $this->viewPath == 'classes',
		'url' => '/' . $this->params['group'] . '/classes'
	));

if(Permission::check('Permission'))
	$menu->addMenuItem('group',array(
		'content' => __('User Permissions', true),
		'class' => 'gclms-facilitators',
		'active' => $this->viewPath == 'permissions',
		'url' => '/' . Group::get('web_path') . '/permissions'
	));

if(Permission::check('Course'))
	$menu->addMenuItem('group',array(
		'content' => __('Courses', true),
		'class' => 'gclms-add',
		'url' => '/' . Group::get('web_path') . '/courses/add'
	));

if(Permission::check('Group'))
	$menu->addMenuItem('group',array(
		'content' => __('Configuration', true),
		'class' => 'gclms-configuration',
		'url' => '/' . Group::get('web_path') . '/configuration'
	));