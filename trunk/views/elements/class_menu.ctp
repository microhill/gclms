<ul class="gclms-primary-column-menu">
	<?
	echo $this->element('menu', array("items" => array(
		array('label' => __('Class Home', true), 'class' => 'gclms-home', 'active' => $this->name == 'Announcements', 'url' => $groupAndCoursePath)
	)));
	
	// If a facilitator
	echo $this->element('menu', array("items" => array(
		array('label' => __('Announcements', true), 'class' => 'gclms-announcements', 'active' => $this->name == 'Announcements2', 'url' => $groupAndCoursePath . '/announcements')
	)));
	
	$menu = array(
		array('label' => __('Books', true), 'class' => 'gclms-books', 'active' => $this->name == 'Books' || $this->name == 'Chapters', 'url' => $groupAndCoursePath . '/books'),
		array('label' => __('Articles', true), 'class' => 'gclms-articles', 'active' => $this->name == 'Articles', 'url' => $groupAndCoursePath . '/articles'),
		array('label' => __('Glossary', true), 'class' => 'gclms-glossary', 'active' => $this->name == 'Glossary', 'url' => $groupAndCoursePath . '/glossary'),
		array('controller' => 'Notebook', 'label' => __('Notebook', true), 'class' => 'gclms-notebook', 'url' => $groupAndCoursePath . '/notebook'),
		array('label' => __('Forums', true), 'class' => 'gclms-forums', 'active' => $this->name == 'Forums', 'url' => $groupAndCoursePath . '/forums'),
		array('label' => __('Chat', true), 'class' => 'gclms-chat', 'active' => $this->name == 'Chat', 'url' => $groupAndCoursePath . '/chat'),
		array('controller' => 'Grades', 'label' => __('Grades', true), 'url' => $groupAndCoursePath . '/grades'),
		//array('label' => __('Configure Class', true), 'class' => 'gclms-configuration', 'active' => $this->name == 'Courses' && $this->action == 'edit', 'url' => $groupAndCoursePath . '/configuration')
	);
	
	echo $this->element('menu', array("items" => $menu));
	?>
</ul>