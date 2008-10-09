<div class="gclms-content">
	<?
	if(!User::get('id') && !(Browser::agent() == 'IE' && Browser::version() < 7))
		echo $this->element('panel',array(
			'title' => 'Login',
			'content' => $this->element('login')
		));

	if(!empty($chat_participants)) {
		echo $this->element('chat_participants');
	}

	if(empty($this->params['administration']) && !empty($user) && $this->name == 'StudentCenter') {
		echo $this->element('panel',array(
			'title' => 'My Classes',
			'content' => $this->element('class_listing')
		));

		if(sizeof($participating_groups) == 1) {
			$groupName = $participating_groups[0]['Group']['name'];
			
			echo $this->element('panel',array(
				'title' => $groupName,
				'content' => $this->element('group_menu2',array(
					'group' => $participating_groups[0]['Group']
				))
			));
		} else if(sizeof($participating_groups) > 1){
			echo $this->element('panel',array(
				'title' => 'My Groups',
				'content' => $this->element('group_listing')
			));	
		}
	}
	
	if(empty($this->params['administration']) && !empty($user) && $this->name == 'Groups') {
		echo $this->element('panel',array(
			'title' => 'Courses',
			'content' => $this->element('course_listing')
		));
	}

	if(!$offline && ($this->name == 'StudentCenter' || $this->name == 'Groups'))
		echo $this->element('choose_language');

	if(!isset($course) && isset($virtual_classes) && isset($group) && isset($course)) {
		echo $this->element('panel',array(
			'title' => 'Open Classes',
			'content' => $this->element('open_classes')
		));
	}
	
	if($this->name == 'Announcements') {
		echo $this->element('../class/secondary_column');
	}

	?>
	<div><!-- This empty tag fixes an IE bug --></div>
</div>