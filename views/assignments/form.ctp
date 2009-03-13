<?
echo $form->input('title',array(
	'label' =>  __('Title', true),
	'between' => '<br/>',
	'size' => 40
));

$weeks = array();
for($x = 0; $x < 52; $x++) {
	$weeks[$x + 1] = __('Week', true) . ' ' . ($x + 1);
}

$days = array();
for($x = 0; $x < 7; $x++) {
	$days[$x + 1] = __('Day', true) . ' ' . ($x + 1);
}
?>

<!-- p>
<?
echo $form->input('type',array(
	'label' =>  __('Type', true),
	'options' => array(
		'quiz' => 'Quiz',
		'chat' => 'Chat participation',
		'forum' => 'Forum participation',
		'notebook' => 'Notebook submission',
		'other' => 'Other'),
	'between' => '<br/>'
));
?>
</p -->

<fieldset>
	<legend><? __('Associated objects') ?></legend>
	<div id="gclms-associated-objects">
		<?
		if(!empty($this->data['AssignmentAssociation'])) {
			foreach($this->data['AssignmentAssociation'] as $assignment_association) {
				if($assignment_association['model'] == 'Page') {
					echo $this->element('../assignments/page_object',$assignment_association);
				} else if($assignment_association['model'] == 'Forum') {
					echo $this->element('../assignments/forum_object',$assignment_association);
				}
			}	
		}
		?>
	</div>
	<div id="gclms-add-associated-object">
		<table cellspacing="0" border="0" cellpadding="0">
			<tr>
				<td>
					<?
					echo $form->input('associated_object_type',array(
						'label' =>  false,
						'options' => array(
							'Page' => 'Page',
							//'chatroom' => 'Chatroom',
							'Forum' => 'Forum',
							//'wiki_page' => 'Wiki page'
						)
					));
					
					?>
				</td>
				<td>
					<button class="gclms-add"><? __('Add') ?></button>
				</td>
			</tr>
		</table>
	</div>
</fieldset>

<div id="gclms-reminder-page">
	<label><? __('Remind user of assignment after this page') ?></label>
	<table cellspacing="0" border="0" cellpadding="0">
		<tr>
			<td>
				<input id="AssignmentNodeTitle" disabled="disabled" /><input type="hidden" name="data[Assignment][node_id]" id="AssignmentNodeId" />
			</td>
			<td>
				<button><? __('Change') ?></button>
			</td>
		</tr>
	</table>
</div>

<?= $form->input('points',array(
	'label' =>  __('Points', true),
	'between' => '<br/>',
	'size' => 5
));
?>

<!-- p id="gclms-time-limit-chooser">
<?
echo $form->input('time_limit',array(
	'label' =>  __('Time limit (minutes)', true),
	'between' => '<br/>',
	'size' => 5,
	'div' => false
));
?>
</p -->

<!--p id="gclms-quiz-availability-date" class="">
<?
echo __('Availability date',true) . '<br/>';

echo $form->input('has_availability_date',array(
	'label' =>  false,
	'between' => false,
	'type' => 'checkbox',
	'div' => false
));

echo $form->input('availability_date_week',array(
	'label' =>  false,
	'options' => $weeks,
	'between' => false,
	'div' => false
));
echo ' ';

echo $form->input('availability_date_day',array(
	'label' =>  false,
	'options' => $days,
	'between' => false,
	'div' => false
));
?>
</p -->
<?


echo '<p>';
echo __('Due date',true) . '<br/>';

echo $form->input('has_due_date',array(
	'label' =>  false,
	'between' => false,
	'type' => 'checkbox',
	'div' => false,
	'checked' => !empty($this->data['Assignment']['due_date'])
));

echo $form->input('due_date_week',array(
	'label' =>  false,
	'options' => $weeks,
	'between' => false,
	'div' => false
));
echo ' ';

echo $form->input('due_date_day',array(
	'label' =>  false,
	'options' => $days,
	'between' => false,
	'div' => false
));
echo '</p>';

?>
<!-- p><?= $form->checkbox('prevent_late_submission', array(
	'checked' => isset($data['Assignment']['prevent_late_submission']) ? $data['Assignment']['prevent_late_submission'] : true
)
); ?> <label for="AssignmentOverridable2">Prevent late submissions</label></p -->
<?
/*
echo $form->date('due_date',false,array(
	'label' =>  __('Due date', true),
	'between' => '<br/>'
));
*/
echo $form->input('description',array(
	'label' => __('Description',true),
	'between' => '<br/>',
	'rows' => 13,
	'cols' => 80,
	'class' => 'wysiwyg'
));
?>
<!-- p><?= $form->checkbox('overridable', array(
	'checked' => isset($data['Assignment']['overridable']) ? $data['Assignment']['overridable'] : true
)
); ?> <label for="AssignmentOverridable">Facilitators can override this assignment</label></p -->
	
	<!-- p><?= $form->checkbox('calculated', array(
		'checked' => isset($data['Assignment']['calculated']) ? $data['Assignment']['calculated'] : true
	)
	); ?> <label for="AssignmentOverridable2">Calculated</label></p -->
	
	<!-- ?
	echo $form->input('allowed_attempts',array(
		'label' =>  __('Allowed attempts', true),
		'between' => '<br/>',
		'size' => 5
	));
	? -->
	
	<!-- p>
	<?
	echo $form->input('grading_method',array(
		'label' =>  __('Grading method', true),
		'options' => array(
			'Highest grade',
			'Average grade',
			'First attempt',
			'Last attempt'
		),
		'between' => '<br/>'
	));
	?>
	</p -->

<!--
Assignment type

 - Quiz (id)  
   - Time limit (minutes)
   - Time delay between first and second attempt
   - Grading method
    - Highest grade, average grade, first attempt (other attempts are ignored), last attempt
   - Score immediately shown to student?
   
 - General chatroom participation (calculated)
   - Words
   - Spread out through X different days (leave at 0 if no concern)
 - Specific chatroom participation (calculated)
 - General forum participation (calculated)
 - Specific forum participation
 - Other, submitted by 
   - Personal message
   - Other
 - Student blog
 
Future:

 - Wiki participation
-->

<script>
var pageObjectView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../assignments/page_object',array(
	'id' => '#{id}',
	'title' => '#{title}',
	'foreign_key' => '#{foreign_key}',
	'results_figured_into_grade' => '#{results_figured_into_grade}',
	'percentage_of_grade' => '0'
	
)))); ?>;
var forumObjectView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../assignments/forum_object',array(
	'id' => '#{id}',
	'title' => '#{title}',
	'foreign_key' => '#{foreign_key}'
)))); ?>;
</script>