<?
if(empty($question_id) || empty($answer_id))
	die();
?>

<div class="gclms-order" <?= empty($answer['id']) ? 'style="display: none;"' : '' ?>>
	<?
	echo $form->hidden('Question.' . $question_id . '.OrderAnswer.' . $answer_id . '.id',array(
		'value' => @$answer['id'],
		'name' => "data[Question][$question_id][OrderAnswer][$answer_id][id]"
	));
	?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tr>
			<th colspan="2" class="gclms-answer-header">
				<div class="gclms-left">
					<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" class="deleteAnswer" gclms:confirm-text="<? __('Are you sure you want to delete this answer?') ?>"/>
				</div>

				<div class="gclms-right">
					<img src="/img/icons/crystal_clear/16x16/actions/move.png" alt="<? __('Move up') ?>" />
				</div>
				
			</th>
		</tr>
		<tr>
			<th>
				<?
				echo $form->label('Question' . $question_id . 'OrderAnswer' . $answer_id . 'text','Text');
				?>
			</th>
			<td>
				<?
				echo $form->text('Question' . $question_id . 'OrderAnswer' . $answer_id . 'text',array(
					'label' => false,
					'value' => @$answer['text1'],
					'div' => false,
					'name' => "data[Question][$question_id][OrderAnswer][$answer_id][text1]"
				));
				?>

			</td>
		</tr>
	</table>
</div>