<?
$question_id = empty($question_id) ? String::uuid() : $question_id;
if(empty($question_id) && !empty($question['id']))
	$question_id = $question['id'];
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
					<p class="left">
						<button class="deleteQuestion delete" confirm:text="<? __('Are you sure you want to delete this question?') ?>">
							<? __('Delete Question') ?>
						</button>
					</p>

					<p class="right">
						<button class="moveUp">
							<? __('Move up') ?>
						</button>

						<button class="moveDown">
							<? __('Move down') ?>
						</button>
					</p>
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
				<?= $myForm->radio('Question.' . $question_id . '.type',
					array('0' => 'Multiple choice','1' => 'True/false','2' => 'Fill in the blank','3' => 'Matching'),
					array(
					'div' => false,
					'class' => 'questionType',
					'value' => isset($question['type']) ? $question['type'] : '0',
					'separator' => ' ',
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
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<button class="add"><? __('Add Answer') ?></button> <span class="loadingAnswerIndicator"><img src="/img/permanent/spinner2007-09-14.gif" /></span>
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
			<tr class="fillInTheBlank<?= @$question['type'] != '2' ? ' hidden' : '' ?>">
				<th>
				<?
				echo $form->label('Question.' . $question_id . '.fill_in_the_blank_answer','Answer');
				?>
				</th>
				<td>
				<?
				echo $form->input('Question.' . $question_id . '.fill_in_the_blank_answer',array(
					'label' =>  false,
					'size' => 40,
					'div' => false,
					'value' => @$question['fill_in_the_blank_answer'],
					'name' => "data[Question][$question_id][fill_in_the_blank_answer]"
				));
				?>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr class="matchingHeaders<?= @$question['type'] != '3' ? ' hidden' : '' ?>">
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
			<tr class="matching<?= @$question['type'] != '3' ? ' hidden' : '' ?>">
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
									'question_id' => $question_id
								));
							}
						}
						?>
					</div>
					<button class="add"><? __('Add Answer') ?></button> <span class="loadingAnswerIndicator"><img src="/img/permanent/spinner2007-09-14.gif" /></span>
				</td>
			</tr>
		</tbody>
	</table>
	<p>
		<button class="insertQuestion add"><? __('Insert Question') ?></button>
		<button class="insertTextarea add"><? __('Insert Content') ?></button>
	</p>
</div>