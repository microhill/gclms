<?
if(empty($question_id) || empty($answer_id))
	die();
	
if(!isset($totalCorrectMultipleChoiceAnswers))
	$totalCorrectMultipleChoiceAnswers = 0;
?><div class="gclms-multiple-choice gclms-answer" gclms:answer-id="<?= $answer_id ?>">
	<?= $form->hidden('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'id',array(
		'value' => @$answer['id'],
		'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][id]",
		
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
				<?= $form->label('MultipleChoiceAnswer' . $answer_id . 'text','Text'); ?>
			</th>
			<td class="gclms-answer-title">
				<?= $form->input('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'text',array(
					'label' => false,
					'rows' => 2,
					'value' => @$answer['text1'],
					'div' => false,
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][text1]",
					'class' => 'gclms-answer-title gclms-tinymce-disabled gclms-simple-tinymce-enabled',
					'id' => 'MultipleChoiceAnswer' . $answer_id . 'text'
					
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
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][correct]",
					'class' => 'gclms-multiple-choice-answer-correct'
				),array(
					'value' => '1'
				));
				?>
			</td>
		</tr>
		<tr class="gclms-answer-explanation <?= $totalCorrectMultipleChoiceAnswers < 2 ? '' : 'gclms-hidden' ?>">
			<th>
				<?= $form->label('Question' . $question_id . 'MultipleChoiceAnswer' . $answer_id . 'text3','Explanation'); ?>
			</th>
			<td class="<? if(!empty($answer['text3'])) echo 'gclms-filled' ?>">
				<? if(empty($answer['text3'])): ?>
					<img src="/img/icons/oxygen/22x22/apps/kate.png" class="gclms-add-tinymce-box" />
				<?
				else:
					echo $this->element('../pages/answer_multiple_choice_explanation',array(
						'question_id' => $question_id,
						'answer_id' => $answer_id,
						'answer' => @$answer
					));					
				endif; ?>
			</td>
		</tr>
	</table>
</div>