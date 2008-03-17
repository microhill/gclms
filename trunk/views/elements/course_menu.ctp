<?
$menu = array(
	array('label' => __('Course Home', true), 'class' => 'Home', 'active' => $this->name == 'Courses' && $this->action != 'edit', 'url' => $groupAndCoursePath),
	//array('label' => __('Grades', true), 'class' => 'Grades', 'active' => isset($tests) || isset($test) ? true : false, 'url' => '/' . $this->viewVars['group']['web_path'] . '/grades/' . $this->viewVars['course']['web_path']),

	//If group admin?
	array('label' => __('Course Structure', true), 'class' => 'course-content', 'active' => $this->name == 'Content', 'url' => $groupAndCoursePath . '/content'),
	array('label' => __('Media Files', true), 'class' => 'Files', 'active' => $this->name == 'Files', 'url' => $groupAndCoursePath . '/files'),
	array('label' => __('Books', true), 'class' => 'books', 'active' => $this->name == 'Books' || $this->name == 'Chapters', 'url' => $groupAndCoursePath . '/books'),
	array('label' => __('Articles', true), 'class' => 'articles', 'active' => $this->name == 'Articles', 'url' => $groupAndCoursePath . '/articles'),
	array('label' => __('Dictionary', true), 'class' => 'dictionary', 'active' => $this->name == 'Dictionary', 'url' => $groupAndCoursePath . '/dictionary'),
	array('label' => __('Configure Course', true), 'class' => 'Configuration', 'active' => $this->name == 'Courses' && $this->action == 'edit', 'url' => $groupAndCoursePath . '/configuration'),
	array('label' => __('Export Course', true), 'class' => 'export', 'active' => $this->name == 'Export', 'url' => $groupAndCoursePath . '/export')
);

echo $this->renderElement('menu', array("items" => $menu));