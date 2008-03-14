<?
if(empty($question_id) || empty($answer_id))
	die();
?>

<div class="matching" <?= empty($answer['id']) ? 'style="display: none;"' : '' ?>>
	<?
	echo $form->hidden('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.id',array(
		'value' => @$answer['id'],
		'name' => "data[Question][$question_id][MatchingAnswer][$answer_id][id]"
	));
	?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tr>
			<th colspan="2" class="gclms-answer-header">
				<div class="left">
					<button class="deleteAnswer delete left" confirm:text="<? __('Are you sure you want to delete this answer?') ?>">
						<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" />
					</button>		
				</div>
			</th>
		</tr>
		</tr>
			<td class="column">
				<?
				echo $form->text('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.text',array(
					'label' => false,
					'value' => @$answer['text'],
					'div' => false,
					'type' => 'text',
					'name' => "data[Question][$question_id][MatchingAnswer][$answer_id][text1]"
				));
				?>
			</td>
			<td class="column">
				<?
				echo $form->text('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.explanation',array(
					'label' => false,
					'div' => false,
					'value' => @$answer['explanation'],
					'type' => 'text',
					'name' => "data[Question][$question_id][MatchingAnswer][$answer_id][text2]"
				));
				?>
			</td>
		</tr>
	</table>
</div>