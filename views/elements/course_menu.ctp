<?= $this->element('menu', array("items" => array(
	array('label' => __('Course Home', true), 'class' => 'gclms-home', 'active' => $this->name == 'Courses' && $this->action != 'edit', 'url' => $groupAndCoursePath),
	//array('label' => __('Grades', true), 'class' => 'Grades', 'active' => isset($tests) || isset($test) ? true : false, 'url' => '/' . $this->viewVars['group']['web_path'] . '/grades/' . $this->viewVars['course']['web_path']),

	//If group admin?
	Permission::check('Content') ? array('label' => __('Course Structure', true), 'class' => 'gclms-course-content', 'active' => $this->name == 'Content', 'url' => $groupAndCoursePath . '/content') : null,
	array('label' => __('Forums', true), 'class' => 'gclms-forums', 'active' => $this->name == 'Forums', 'url' => $groupAndCoursePath . '/forums'),
	array('label' => __('Chat', true), 'class' => 'gclms-chat', 'active' => $this->name == 'Chat', 'url' => $groupAndCoursePath . '/chat'),
	array('label' => __('Files', true), 'class' => 'gclms-files', 'active' => $this->name == 'Files', 'url' => $groupAndCoursePath . '/files'),
	array('label' => __('Books', true), 'class' => 'gclms-books', 'active' => $this->name == 'Books' || $this->name == 'Chapters', 'url' => $groupAndCoursePath . '/books'),
	array('label' => __('Articles', true), 'class' => 'gclms-articles', 'active' => $this->name == 'Articles', 'url' => $groupAndCoursePath . '/articles'),
	array('label' => __('Glossary', true), 'class' => 'gclms-glossary', 'active' => $this->name == 'Glossary', 'url' => $groupAndCoursePath . '/glossary'),
	array('label' => __('Configure Course', true), 'class' => 'gclms-configuration', 'active' => $this->name == 'Courses' && $this->action == 'edit', 'url' => $groupAndCoursePath . '/configuration'),
	array('label' => __('Export Course', true), 'class' => 'gclms-export', 'active' => $this->name == 'Export', 'url' => $groupAndCoursePath . '/export')
)));