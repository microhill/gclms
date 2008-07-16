<?
if(empty($question_id) || empty($answer_id))
	die();
?><div class="gclms-multiple-choice" gclms:answer-id="<?= $answer_id ?>">
	<?= $form->hidden('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'id',array(
		'value' => @$answer['id'],
		'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][id]"
	)); ?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tr>
			<th colspan="2" class="gclms-answer-header">
				<div class="gclms-left">
					<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" class="gclms-delete-answer gclms-delete" gclms:confirm-text="<? __('Are you sure you want to delete this answer?') ?>" />
				</div>
			</th>
		</tr>
		<tr>
			<th>
				<?= $form->label('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'text','Text'); ?>
			</th>
			<td class="gclms-answer-title">
				<?= $form->input('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'text',array(
					'label' => false,
					'rows' => 2,
					'value' => @$answer['text1'],
					'div' => false,
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][text1]",
					'class' => 'gclms-answer-title gclms-tinymce-disabled gclms-simple-tinymce-enabled'
				)); ?>

			</td>
		</tr>
		<tr>
			<th>
				<?= $form->label('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'correct','Correct'); ?>
			</th>
			<td>
				<?
				echo $myForm->checkbox('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'correct',array(
					'checked' => empty($answer['correct']) ? '' : 'checked',
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][correct]"
				),array(
					'value' => '1'
				));
				?>
			</td>
		</tr>
		<tr class="gclms-answer-explanation">
			<th>
				<?= $form->label('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'text3','Explanation'); ?>
			</th>
			<td>
				<img src="/img/icons/oxygen/16x16/apps/kate.png" class="gclms-add-tinymce-box" />
			</td>
		</tr>
	</table>
</div>