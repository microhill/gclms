<?
if(empty($question_id))
	$question_id = $question['id'];
	
if(empty($question_id))
	die;
?>

<div class="gclms-page-item question" question:id="<?= $question_id ?>">
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
					<div class="left">
						<img src="/img/icons/oxygen/16x16/actions/edit-delete.png" class="deleteQuestion delete" confirm:text="<? __('Are you sure you want to delete this question?') ?>" />
					</div>

					<div class="right">
						<img src="/img/icons/oxygen_refit/16x16/actions/go-up-blue.png" class="moveUp" />

						<img src="/img/icons/oxygen_refit/16x16/actions/go-down-blue.png" class="moveDown" />
					</div>
				</th>
			</tr>
			<tr>
				<th>
					<?
					echo $form->label('Question.' . $question_id . '.title','Title');
					?>
				</th>
				<td>
				<?
				echo $form->input('Question.' . $question_id . '.title',array(
					'label' => false,
					'div' => false,
					'size' => 40,
					'value' => @$question['title'],
					'name' => "data[Question][$question_id][title]",
					'class' => 'gclms-question-title'
				));
				?>
				</td>
			</tr>
			<tr>
				<th>
				<?= $form->label('Question.' . $question_id . '.type','Type'); ?>
				</th>
				<td>
				<?= $myForm->input('Question' . $question_id . 'Type',
					array(
						'options' => array('0' => 'Multiple choice','1' => 'True/false','2' => 'Matching','3' => 'Order','4' => 'Fill in the blank','5' => 'Essay'),
						'type' => 'radio',
						'div' => false,
						'class' => 'questionType',
						'value' => isset($question['type']) ? $question['type'] : '0',
						'separator' => '&nbsp;&nbsp;',
						'legend' => false,
						'name' => "data[Question][$question_id][type]"
				)); ?>
				</td>
			</tr>
			<tr class="multipleChoice<?= !empty($question['type']) && isset($question) ? ' hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="answers<?= empty($question['Answer']) ? ' hidden' : '' ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->renderElement('answer_multiple_choice',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="add" />
				</td>
			</tr>
			<tr class="trueFalse<?= @$question['type'] != '1' ? ' hidden' : '' ?>">
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
			<tr class="order<?= @$question['type'] != '3' ? ' hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="answers<?= empty($question['Answer']) ? ' hidden' : '' ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->renderElement('answer_order',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="add" />
				</td>
			</tr>
			<tr class="fillInTheBlank<?= @$question['type'] != '2' ? ' hidden' : '' ?>">
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
			<tr class="matchingHeaders<?= @$question['type'] != '2' ? ' hidden' : '' ?>">
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
							<td class="column">
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
							<td class="column">
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
			<tr class="matching<?= @$question['type'] != '2' ? ' hidden' : '' ?>">
				<th>
					<? __('Answers'); ?>
				</th>
				<td>
					<div class="answers<?= empty($question['Answer']) ? ' hidden' : '' ?>">
						<?
						if(isset($question['Answer'])) {
							foreach($question['Answer'] as $answer) {
								echo $this->renderElement('answer_matching',array(
									'answer' => $answer,
									'answer_id' => $answer['id'],
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<img src="/img/icons/oxygen_refit/22x22/actions/insert-object.png" class="add" />
				</td>
			</tr>

		</tbody>
		<tbody>
			<tr class="question-explanation<?= @$question['type'] !== '0' && isset($question) ? '' : ' hidden' ?>">
				<th>
					<? __('Explanation'); ?>
				</th>
				<td>
					<? pr($question['type']); if(empty($question['right_column_header'])): ?>
						<img src="/img/icons/oxygen/22x22/apps/kate.png" class="addTinyMCEBox" />
					<?
					else:
						echo $this->renderElement('question_explanation',array(
							'question_id' => $question_id,
							'question' => @$question
						));					
					endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<p>
		<button class="insertQuestion add"><? __('Insert Question') ?></button>
		<button class="insertTextarea add"><? __('Insert Content') ?></button>
	</p>
</div>