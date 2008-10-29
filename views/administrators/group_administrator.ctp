<div class="gclms-group-administrator">
	<?= $form->input('manage_content',array(
		'label' => $group_name,
		'type' => 'checkbox',
		'between' => ' ',
		'name' => 'data[Groups][' . $group_id . ']',
		'checked' => true, //@$this->data['Permissions']['courses'][$course_id]['manage_content'] ? true : false,
		'id' => 'data[GroupAdministrators][' . $group_id . '][manage_content]',
		'value' => $group_name
	)) ?>
</div>