<?
if(empty($question_id) || empty($answer_id))
	die();
?>

<div class="multipleChoice" <?= empty($answer['id']) ? 'style="display: none;"' : '' ?>>
	<?
	echo $form->hidden('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.id',array(
		'value' => @$answer['id'],
		'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][id]"
	));
	?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tr>
			<th colspan="2" class="gclms-answer-header">
				<div class="left">
					<button class="deleteAnswer delete" confirm:text="<? __('Are you sure you want to delete this answer?') ?>">
						<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" />
					</button>		
				</div>
			</th>
		</tr>
		<tr>
			<th>
				<?
				echo $form->label('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.text','Text');
				?>
			</th>
			<td>
				<?
				echo $form->text('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.text',array(
					'label' => false,
					'value' => @$answer['text'],
					'div' => false,
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][text]"
				));
				?>

			</td>
		</tr>
		<tr>
			<th>
				<?
				echo $form->label('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.correct','Correct');
				?>
			</th>
			<td>
				<?
				echo $myForm->checkbox('Question][' . $question_id . '][MultipleChoiceAnswer][' . $answer_id . '.correct',array(
					'checked' => empty($answer['correct']) ? '' : 'checked',
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][correct]"
				),array(
					'value' => '1'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>
				<?
				echo $form->label('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.explanation','Explanation');
				?>
			</th>
			<td>
				<?
				echo $form->text('Question.' . $question_id . '.MultipleChoiceAnswer.' . $answer_id . '.explanation',array(
					'label' => false,
					'div' => false,
					'value' => @$answer['explanation'],
					'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][explanation]"
				));
				?>

			</td>
		</tr>
	</table>
</div>