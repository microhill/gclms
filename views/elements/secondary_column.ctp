<div class="gclms-content">
	<?
	if(empty($user) && !(Browser::agent() == 'IE' && Browser::version() < 7))
		echo $this->renderElement('panel',array(
			'title' => 'Login',
			'content' => $this->renderElement('login')
		));

	if(!empty($chat_participants)) {
		echo $this->renderElement('chat_participants');
	}

	if(empty($this->params['administration']) && !empty($user) && $this->name == 'StudentCenter') {
		echo $this->renderElement('panel',array(
			'title' => 'My Classes',
			'content' => $this->renderElement('class_listing')
		));

		if(sizeof($participating_groups) == 1) {
			$groupName = $participating_groups[0]['Group']['name'];
			
			echo $this->renderElement('panel',array(
				'title' => $groupName,
				'content' => $this->renderElement('group_menu2',array(
					'group' => $participating_groups[0]['Group']
				))
			));
		} else if(sizeof($participating_groups) > 1){
			echo $this->renderElement('panel',array(
				'title' => 'My Groups',
				'content' => $this->renderElement('group_listing')
			));	
		}
	}
	
	if(empty($this->params['administration']) && !empty($user) && $this->name == 'Groups') {
		echo $this->renderElement('panel',array(
			'title' => 'Courses',
			'content' => $this->renderElement('course_listing')
		));
	}

	if($this->name == 'StudentCenter' && empty($user))
		echo $this->renderElement('choose_language');

	if($this->name == 'Lessons' && $this->action == 'index')
		echo $this->renderElement('panel',array(
			'title' => 'What can I do here?',
			'content' => $this->renderElement('units_and_lessons_tutorial')
		));
	else if($this->name == 'Lessons' && $this->action == 'view')
		echo $this->renderElement('panel',array(
			'title' => 'What can I do here?',
			'content' => $this->renderElement('topics_and_pages_tutorial')
		));

	if(!isset($facilitated_class) && isset($facilitated_classes) && isset($group) && isset($course)) {
		echo $this->renderElement('panel',array(
			'title' => 'Open Classes',
			'content' => $this->renderElement('open_classes')
		));
	}

	if(isset($lessons) && $this->name != 'Lessons' && !empty($course['web_path'])) {
		if(strlen($course['description']) > 1500) {
			echo $this->renderElement('panel',array(
				'title' => 'Lessons',
				'content' => $this->renderElement('lesson_listing')
			));
		}
		echo $this->renderElement('panel',array(
			'title' => 'Course Audio',
			'content' => $this->renderElement('course_audio')
		));
	}

	?>
	<div><!-- This empty tag fixes an IE bug --></div>
</div>