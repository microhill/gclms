<? if(!empty($this->data['User'])): ?>
	<?= $form->hidden('User.id') ?>
	<div id="gclms-user">
		<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($this->data['User']['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" style="float:left;margin-right: 10px;margin-bottom: 10px;" />
		<h2><?= $this->data['User']['username'] ?></h2>
		<div><em><?= $this->data['User']['email'] ?></em></div>
		<? if($this->action == 'add'): ?>
			<p><button id="gclms-change-user"><? __('Change') ?></button></p>
		<? endif; ?>
	</div>
<? endif; ?>

<div id="gclms-user-permissions" class="<? if(empty($this->data['User'])): ?>gclms-hidden<? endif; ?>" style="clear: both;">
	<h2>Group-wide Permissions</h2>
	
	<p>
		<?= $form->input('administer',array(
			'label' => 'Administer group',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][group][administer]',
			'checked' => @$this->data['Permissions']['group']['administer']
		)) ?>
	</p>
	
	<p>
		<?= $form->input('manage_user_permissions',array(
			'label' => 'Manage user permissions',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][group][manage_user_permissions]',
			'checked' => @$this->data['Permissions']['group']['manage_user_permissions']
		)) ?>
	</p>
	
	<p>
		<?= $form->input('manage_courses',array(
			'label' => 'Manage all courses',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][group][manage_courses]',
			'checked' => @$this->data['Permissions']['group']['manage_courses']
		)) ?>
	</p>
	
	<p>
		<?= $form->input('manage_classes',array(
			'label' => 'Manage all classes',
			'type' => 'checkbox',
			'between' => ' ',
			'name' => 'data[Permissions][group][manage_classes]',
			'checked' => @$this->data['Permissions']['group']['manage_classes']
		)) ?>
	</p>
	
	<h2>Specific Course Permissions</h2>
	<?
	$courseSelectionList = $courses;
	if(!empty($this->data['Permissions']['courses'])) {
		foreach($this->data['Permissions']['courses'] as $course_id => $course) {
			unset($courseSelectionList[$course_id]);
		}		
	}

	?>

	<?
	if(!empty($courseSelectionList)): ?>
		<div id="gclms-course-selection">
			<table class="gclms-buttons">
				<tr>
					<td>
						<?
						echo $form->input('Course.selection',array(
							'options' => $courseSelectionList,
							'div' => false,
							'label' => false,
							'id' => 'gclms-unselected-courses',
							'name' => ''
						));
						?>
					</td>
					<td>
						<button id="gclms-add-course"><? __('Select Course') ?></button>
					</td>
				</tr>
			</table>
		</div>
	<? endif; ?>

	<div id="gclms-courses">
		<?
		if(!empty($this->data['Permissions']['courses'])) {
			foreach($this->data['Permissions']['courses'] as $course_id => $course) {
				echo $this->element('../permissions/course_permissions',array(
					'course_title' => $courses[$course_id],
					'course_id' => $course_id
				));
			}	
		}
		?>
	</div>

	<? if(!empty($classes)): ?>
		<h2>Specific Class Permissions</h2>
		<p>
			<? echo $form->input('Class.selection',array(
				'options' => $classes,
				'div' => false,
				'label' => false,
				'id' => 'gclms-class-selection'
			));
			?><button id="gclms-add-class"><? __('Select Class') ?></button>	
		</p>
	<? endif; ?>
</div>

<script>
var tmpCoursePermissionsView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../permissions/course_permissions',array(
	'course_title' => '#{course_title}',
	'course_id' => '#{course_id}'
)))); ?>;
</script>