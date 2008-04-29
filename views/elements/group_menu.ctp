<?
echo $this->renderElement('menu', array("items" => array(
	array('label' => __('Group Home', true),'class' => 'gclms-home', 'controller' => null, 'url' => '/' . $this->params['group'], 'active' => $this->viewPath == 'groups' && count($this->params['pass']) == 0),
	array('controller' => 'FacilitatedClasses', 'class' => 'gclms-courses', 'label' => __('Classes', true),'url'=>'/' . $this->params['group'] . '/classes', 'active' => $this->viewPath == 'classes'),
	array('controller' => 'Facilitators','class'=>'gclms-facilitators','url' => '/' . $group['web_path'] . '/facilitators', 'active' => $this->viewPath == 'facilitators' && $this->action != 'register'),
	array('controller' => 'Courses','label' => __('Add Course', true),'class' => 'gclms-add','url' => '/' . $group['web_path'] . '/courses/add'),
	array('controller' => 'Configuration', 'class'=>'gclms-configuration','label' => __('Configure Group', true),'url' => '/' . $group['web_path'] . '/configuration')
)));