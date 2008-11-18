<ul class="gclms-primary-column-menu">
	<?= $this->element('menu', array("items" => array(
		array('label' => __('Group Home', true),'class' => 'gclms-home', 'controller' => null, 'url' => '/' . $this->params['group'], 'active' => $this->viewPath == 'groups' && count($this->params['pass']) == 0),
		Permission::check('VirtualClass') ? array('controller' => 'FacilitatedClasses', 'class' => 'gclms-courses', 'label' => __('Classes', true),'url'=>'/' . $this->params['group'] . '/classes', 'active' => $this->viewPath == 'classes') : null,
		Permission::check('Permission') ? array('controller' => 'User Permissions','class'=>'gclms-facilitators','url' => '/' . Group::get('web_path') . '/permissions', 'active' => $this->viewPath == 'permissions') : null,
		Permission::check('Course') ? array('controller' => 'Courses','label' => __('Add Course', true),'class' => 'gclms-add','url' => '/' . Group::get('web_path') . '/courses/add') : null,
		Permission::check('Group') ? array('controller' => 'Configuration', 'class'=>'gclms-configuration','label' => __('Configure Group', true),'url' => '/' . Group::get('web_path') . '/configuration') : null
	)));
	?>
</ul>