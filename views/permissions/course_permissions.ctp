<fieldset class="gclms-course-permissions">
	<legend><?= $course_title ?></legend>		
	<p>
		<?= $form->input('manage_content',array(
			'label' => 'Manage content',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][courses][' . $course_id . '][manage_content]',
			'value' => @$this->data['Permissions']['courses'][$course_id]['manage_content'],
			'id' => 'data[Permissions][courses][' . $course_id . '][manage_content]'
		)) ?>
	</p>
	
	<p>
		<?= $form->input('add_class_for_approval',array(
			'label' => 'Add class for approval',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][courses][' . $course_id . '][add_class_for_approval]',
			'value' => @$this->data['Permissions']['courses'][$course_id]['add_class_for_approval'],
			'id' => 'data[Permissions][courses][' . $course_id . '][add_class_for_approval]',
			'class' => 'gclms-add-class-for-approval'
		)) ?>
	</p>
	
	<p>
		<?= $form->input('add_class_without_approval',array(
			'label' => 'Add class without approval',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][courses][' . $course_id . '][add_class_without_approval]',
			'value' => @$this->data['Permissions']['courses'][$course_id]['add_class_without_approval'],
			'id' => 'data[Permissions][courses][' . $course_id . '][add_class_without_approval]',
			'class' => 'gclms-add-class-without-approval'
		)) ?>
	</p>
	
	<p>
		<?= $form->input('manage_forums',array(
			'label' => 'Manage forums',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][courses][' . $course_id . '][manage_forums]',
			'value' => @$this->data['Permissions']['courses'][$course_id]['manage_forums'],
			'id' => 'data[Permissions][courses][' . $course_id . '][manage_forums]'
		)) ?>
	</p>
	
	<p>
		<?= $form->input('moderate_chatroom',array(
			'label' => 'Moderate chatroom',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][courses][' . $course_id . '][moderate_chatroom]',
			'value' => @$this->data['Permissions']['courses'][$course_id]['moderate_chatroom'],
			'id' => 'data[Permissions][courses][' . $course_id . '][moderate_chatroom]'
		)) ?>
	</p>
</fieldset>