<?
if(empty($question_id))
	$question_id = $question['id'];
	
if(empty($question_id))
	die;
?>

<div class="gclms-page-item gclms-question" question:id="<?= $question_id ?>">
	<?
	echo $form->hidden('Question.' . $question_id . '.id',array(
		'value' => @$question['id'],
		'name' => "data[Question][$question_id][id]"
	));
	?>
	<table class="gclms-tabular-form" cellspacing="0">
		<tbody>
			<tr>
				<th colspan="2">
					<div class="gclms-left">
						<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" class="gclms-delete-question gclms-delete" gclms:confirm-text="<? __('Are you sure you want to delete this question?') ?>" />
					</div>

					<div class="gclms-right">
						<img src="/img/icons/oxygen_refit/16x16/actions/go-up-blue.png" class="gclms-move-up" alt="<? __('Move up') ?>" />

						<img src="/img/icons/oxygen_refit/16x16/actions/go-down-blue.png" class="gclms-move-down" alt="<? __('Move down') ?>" />
					</div>
				</th>
			</tr>
			<tr>
				<th>
					<?
					echo $form->label('Question.' . $question_id . '.title','Question');
					?>
				</th>
				<td>
				<?
				echo $form->input('Question.' . $question_id . '.title',array(
					'label' => false,
					'div' => false,
					//'size' => 40,
					'rows' => 2,
					'value' => @$question['title'],
					'name' => "data[Question][$question_id][title]",
					'class' => 'gclms-question-title gclms-tinymce-disabled'
				));
				?>
				</td>
			</tr>
			<tr>
				<th>
				<?= $form->label('Question' . $question_id . 'Type','Type'); ?>
				</th>
				<td>
				<?= $myForm->input('Question' . $question_id . 'Type',
					array(
						'options' => array(
							'0' => __('Multiple choice',true),
							'1' => __('True/false'),
							'2' => __('Matching'),
							'3' => __('Ordered List'),
							'4' => __('Fill in the blank'),
							'5' => __('Essay')),
						'type' => 'radio',
						'div' => false,
						'class' => 'gclms-question-type',
						'value' => isset($question['type']) ? $question['type'] : '0',
						'separator' => '&nbsp;&nbsp;',
						'legend' => false,
						'name' => "data[Question][$question_id][type]"
				)); ?>
				</td>
			</tr>
			<tr class="gclms-multiple-choice<?= !empty($question['type']) && isset($question) ? ' gclms-hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="gclms-answers<?= empty($question['Answer']) ? ' gclms-hidden' : '' ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->element('answer_multiple_choice',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="gclms-add" />
				</td>
			</tr>
			<tr class="gclms-true-false<?= @$question['type'] != '1' ? ' gclms-hidden' : '' ?>">
				<th>
					<?
					echo $form->label('Question.' . $question_id . '.true_false_answer','Answer');
					?>
				</th>
				<td>
					<?
					echo $myForm->radio('Question.' . $question_id . '.true_false_answer',array('1' => 'True','0' => 'False'),array(
						'div' => false,
						'value' => isset($question['true_false_answer']) ? $question['true_false_answer'] : '1',
						'separator' => ' ',
						'legend' => false,
						'name' => "data[Question][$question_id][true_false_answer]"
					));
					?>
				</td>
			</tr>
			<tr class="gclms-order<?= @$question['type'] != '3' ? ' gclms-hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="gclms-answers<?= empty($question['Answer']) ? ' gclms-hidden' : '' ?>" id="<?= String::uuid() ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->element('answer_order',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="gclms-add" />
				</td>
			</tr>
			<tr class="gclms-fill-in-the-blank<?= @$question['type'] != '4' ? ' gclms-hidden' : '' ?>">
				<th>
				<?
				echo $form->label('Question.' . $question_id . '.text_answer','Answer');
				?>
				</th>
				<td>
				<?
				echo $form->input('Question.' . $question_id . '.text_answer',array(
					'label' =>  false,
					'size' => 40,
					'div' => false,
					'value' => @$question['text_answer'],
					'name' => "data[Question][$question_id][text_answer]"
				));
				?>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr class="gclms-matching-headers<?= @$question['type'] != '2' ? ' gclms-hidden' : '' ?>">
				<th>
					<? __('Headers') ?>
				</th>
				<td>
					<table class="gclms-tabular-form" cellspacing="0">
						<tr>
							<th>
								<?
								echo $form->label('Question.' . $question_id . '.left_column_header','Left Column');
								?>
							</th>
							<th>
								<?
								echo $form->label('Question.' . $question_id . '.right_column_header','Right Column');
								?>
							</th>
						</tr>
						<tr>
							<td class="gclms-column">
								<?
								echo $form->input('Question.' . $question_id . '.left_column_header',array(
									'label' =>  false,
									'size' => 30,
									'div' => false,
									'value' => @$question['left_column_header'],
									'name' => "data[Question][$question_id][left_column_header]"
								));
								?>
							</td>
							<td class="gclms-column">
								<?
								echo $form->input('Question.' . $question_id . '.right_column_header',array(
									'label' =>  false,
									'size' => 30,
									'div' => false,
									'value' => @$question['right_column_header'],
									'name' => "data[Question][$question_id][right_column_header]"
								));
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="gclms-matching<?= @$question['type'] != '2' ? ' gclms-hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="gclms-answers<?= empty($question['Answer']) ? ' gclms-hidden' : '' ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->element('answer_matching',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="gclms-add" />
				</td>
			</tr>

		</tbody>
		<tbody>
			<tr class="gclms-question-explanation<?= @$question['type'] !== '0' && isset($question) ? '' : ' gclms-hidden' ?>">
				<th>
					<? __('Explanation'); ?>
				</th>
				<td class="<?= !empty($question['explanation']) ? 'gclms-filled' : '' ?>">
					<? if(empty($question['explanation'])): ?>
						<img src="/img/icons/oxygen/22x22/apps/kate.png" class="gclms-add-tinymce-box" />
					<?
					else:
						echo $this->element('question_explanation',array(
							'question_id' => $question_id,
							'question' => @$question
						));					
					endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<p>
		<button class="gclms-insert-question gclms-add"><? __('Insert Question') ?></button>
		<button class="gclms-insert-textarea gclms-add"><? __('Insert Content') ?></button>
	</p>
</div>