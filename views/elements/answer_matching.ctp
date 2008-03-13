<?
if(empty($question_id))
	die();
$answer_id = String::uuid();
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
		<!-- tr>
			<th>
				<?= $form->label('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.text','Left Column'); ?>
			</th>
			<th>
				<?= $form->label('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.explanation','Right Column'); ?>
			</th>
		</tr -->
		</tr>
			<td class="column">
				<?
				echo $form->text('Question.' . $question_id . '.MatchingAnswer.' . $answer_id . '.text',array(
					'label' => false,
					'value' => @$answer['text'],
					'div' => false,
					'type' => 'text',
					'name' => "data[Question][$question_id][MatchingAnswer][$answer_id][text]"
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
					'name' => "data[Question][$question_id][MatchingAnswer][$answer_id][explanation]"
				));
				?>
			</td>
		</tr>
	</table>
</div>