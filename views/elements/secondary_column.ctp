<div class="gclms-content">
	<?
	if(!User::get('id') && !(Browser::agent() == 'IE' && Browser::version() < 7))
		echo $this->element('block',array(
			'title' => 'Login',
			'content' => $this->element('login')
		));

	if(empty($this->params['administration']) && User::get('id') && $this->name == 'StudentCenter') {
		$this->element('class_listing');
		if(sizeof($my_groups) == 1 && 0) {
			$groupName = $my_groups[0]['Group']['name'];
			
			echo $this->element('block',array(
				'title' => $groupName,
				'content' => $this->element('group_menu2',array(
					'group' => $my_groups[0]['Group']
				))
			));
		} else {
			$this->element('group_listing');
		}
	}
	
	if(!$offline && ($this->name == 'StudentCenter' || $this->name == 'Groups'))
		echo $this->element('choose_language');

	if(!isset($course) && isset($virtual_classes) && isset($group) && isset($course)) {
		echo $this->element('block',array(
			'title' => 'Open Classes',
			'content' => $this->element('open_classes')
		));
	}
	
	$menu->renderSectionToBlocks('secondary_column');
	echo $block->renderSection('secondary_column');

	?>
	<div><!-- This empty tag fixes an IE bug --></div>
</div>