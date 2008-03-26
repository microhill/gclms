<div class="gclms-matching"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultPartiallyCorrectMessage="<? __('You are partially correct. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h5><?= $question['title'] ?></h5>
	<div class="gclms-answers">
		<div class="gclms-left-column">
			<? if(!empty($question['left_column_header'])): ?>
			<h3><?= $question['left_column_header'] ?></h3>
			<? endif; ?>
			<table cellspacing="4">
				<tbody>
				<?
				$count = 1;
				$colors = array(0,1,2,3,4,5,6,7,8);
				shuffle($colors);
				foreach($question['Answer'] as $answer): 
				?>
					<tr>
						<td class="gclms-draggable-container">
							<div class="gclms-draggable gclms-draggable-color<?= $colors[$count % 9] ?>" answer:id="<?= $answer['id'] ?>">
								<?= $count ?>
							</div>
						</td>
						<td class="gclms-text">
							<div><?= $answer['text1'] ?></div>
						</td>
					</tr>
				<?
					$count++;
				endforeach; 
				?>
				</tbody>
			</table>
		</div>
		<div class="gclms-right-column">
			<? if(!empty($question['right_column_header'])): ?>
			<h3><?= $question['right_column_header'] ?></h3>
			<? endif; ?>
			<table cellspacing="4">
				<tbody>
				<?
				shuffle($question['Answer']);
				foreach($question['Answer'] as $answer):
				?>
					<tr>
						<td class="gclms-droppable-container">
							<div class="gclms-droppable gclms-default-droppable-color" correctAnswer:id="<?= $answer['id'] ?>">&nbsp;</div>
						</td>
						<td class="gclms-description">
							<div><?= $answer['text2'] ?></div>
						</td>
					</tr>
				<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<p>
		<button class="gclms-check-answer-button"><? __('Check answer') ?></button>
	</p>
</div>