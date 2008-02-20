<?
$menu = array(
	// If student
	array('label' => __('Class Home', true), 'class' => 'Home', 'active' => $this->name == 'Class', 'url' => $groupAndCoursePath),
	//array('controller' => 'Notebook', 'label' => __('Life Notebook', true), 'class' => 'LifeNotebook', 'url' => $groupAndCoursePath . '/notebook'),
	//array('controller' => 'Forum', 'label' => __('Class Discussion', true), 'class' => 'ClassDiscussion', 'url' => $groupAndCoursePath . '/forum'),
	//array('controller' => 'Chat', 'label' => __('Live Chat', true), 'class' => 'LiveChat', 'url' => $groupAndCoursePath . '/chat'),
	array('controller' => 'Grades', 'label' => __('Grades', true), 'url' => $groupAndCoursePath . '/grades'),

	// If facilitator
	array('controller' => 'News','class'=> 'news', 'label' => __('Announcements', true), 'url' => $groupAndCoursePath . '/announcements'),
);

echo $this->renderElement('menu', array("items" => $menu));