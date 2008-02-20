<?
echo $this->renderElement('menu', array("items" => array(
	array('label' => __('Group Home', true),'class' => 'Home', 'controller' => null, 'url' => '/' . $this->params['group'], 'active' => $this->viewPath == 'groups' && count($this->params['pass']) == 0),
	array('controller' => 'FacilitatedClasses', 'class' => 'Courses', 'label' => __('Facilitated Classes', true),'url'=>'/' . $this->params['group'] . '/facilitated_classes', 'active' => $this->viewPath == 'facilitated_classes'),
	array('controller' => 'Facilitators','url' => '/' . $group['web_path'] . '/facilitators', 'active' => $this->viewPath == 'facilitators' && $this->action != 'register'),
	array('controller' => 'Facilitators2','label' => __('Register as Facilitator', true),'class' => 'register','url' => '/' . $group['web_path'] . '/facilitators/register', 'active' => $this->viewPath == 'facilitators' && $this->action == 'register'),
	array('controller' => 'Courses','label' => __('Add Course', true),'class' => 'add','url' => '/' . $group['web_path'] . '/courses/add'),
	array('controller' => 'Configuration', 'label' => __('Configure Group', true),'url' => '/' . $group['web_path'] . '/configuration')
)));