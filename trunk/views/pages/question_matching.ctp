<?
$translatedPhrases->add('Incorrect. Try again.',__('Incorrect. Try again.',true));
$translatedPhrases->add('You are partially correct. Try again.',__('You are partially correct. Try again.',true));
$translatedPhrases->add('Correct!',__('Correct!',true));
$translatedPhrases->add('You are out of tries. The correct answer is shown.',__('You are out of tries. The correct answer is shown.',true));

$correctAnswers = array_combine(Set::extract($question['Answer'],'{n}.text1'),Set::extract($question['Answer'],'{n}.text2'));
?>

<div class="gclms-matching" gclms:tries-remaining="3">
	<div class="gclms-correct-answers-json">
		<?= $javascript->object($correctAnswers); ?>
	</div>
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<div class="gclms-answers">
		<div class="gclms-left-column">
			<? if(!empty($question['left_column_header'])): ?>
			<h6><?= $question['left_column_header'] ?></h6>
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
			<h6><?= $question['right_column_header'] ?></h6>
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
	<div class="gclms-answer-status"><span></span></div>
	<div class="gclms-explanation">
		<?= $question['explanation'] ?>
	</div>
	<?
	if(sizeof($correctAnswers) > 1)
		echo $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Check answer',true),
				'class' => 'gclms-check-answer-button'
			)
		)));
	?>
</div>