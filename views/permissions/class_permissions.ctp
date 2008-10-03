<fieldset>
	<legend>Test Class</legend>
	<p>
		<?= $form->input('class_manage_announcements',array(
			'label' => 'Manage announcements',
			'type' => 'checkbox',
			'between' => ' '
		)) ?>
	</p>

	<p>
		<?= $form->input('class_manage_grades',array(
			'label' => 'Manage grades',
			'type' => 'checkbox',
			'between' => ' '
		)) ?>
	</p>

	<p>
		<?= $form->input('class_manage_forums',array(
			'label' => 'Manage forums',
			'type' => 'checkbox',
			'between' => ' '
		)) ?>
	</p>

	<p>
		<?= $form->input('class_moderate_forums',array(
			'label' => 'Moderate forums',
			'type' => 'checkbox',
			'between' => ' '
		)) ?>
	</p>	
	<p>
		<?= $form->input('class_manage_chatroom',array(
			'label' => 'Manage chatroom',
			'type' => 'checkbox',
			'between' => ' '
		)) ?>
	</p>
</fieldset>