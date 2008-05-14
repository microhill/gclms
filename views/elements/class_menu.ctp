<?
$menu = array(
	// If student
	array('label' => __('Class Home', true), 'class' => 'gclms-home', 'active' => $this->name == 'Class', 'url' => $groupAndCoursePath),
	array('label' => __('Books', true), 'class' => 'gclms-books', 'active' => $this->name == 'Books' || $this->name == 'Chapters', 'url' => $groupAndCoursePath . '/books'),
	array('label' => __('Articles', true), 'class' => 'gclms-articles', 'active' => $this->name == 'Articles', 'url' => $groupAndCoursePath . '/articles'),
	array('label' => __('Glossary', true), 'class' => 'gclms-glossary', 'active' => $this->name == 'Glossary', 'url' => $groupAndCoursePath . '/glossary'),
	array('controller' => 'Notebook', 'label' => __('Notebook', true), 'class' => 'gclms-notebook', 'url' => $groupAndCoursePath . '/notebook'),
	array('controller' => 'Forum', 'label' => __('Discussion Forums', true), 'class' => 'gclms-forums', 'url' => $groupAndCoursePath . '/forum'),
	array('controller' => 'Chat', 'label' => __('Chat', true), 'class' => 'gclms-chat', 'url' => $groupAndCoursePath . '/chat'),
	array('controller' => 'Grades', 'label' => __('Grades', true), 'url' => $groupAndCoursePath . '/grades'),
	array('label' => __('Configure Class', true), 'class' => 'gclms-configuration', 'active' => $this->name == 'Courses' && $this->action == 'edit', 'url' => $groupAndCoursePath . '/configuration'),
	//array('controller' => 'Grades', 'label' => __('Grades', true), 'url' => $groupAndCoursePath . '/mail'),
);

echo $this->renderElement('menu', array("items" => $menu));