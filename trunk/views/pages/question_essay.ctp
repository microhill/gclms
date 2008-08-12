<div class="gclms-order-question"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultPartiallyCorrectMessage="<? __('You are partially correct. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h5><?= $question['title'] ?></h5>
	<textarea></textarea>
	
	<!--
	<ul class="gclms-answers" id="<?= String::uuid() ?>">
	<?
	shuffle($question['Answer']);
	
	foreach($question['Answer'] as $answer) {
		$text = $answer['text1'];
		echo "<li gclms:question-id='" . $answer['id'] . "' gclms:answer-order='" . $answer['order'] . "'>$text</li>";
	}
	?>
	</ul>
	-->
	<?= $this->element('buttons',array('buttons' => array(
		array(
			'text' => __('Check answer',true),
			'class' => 'gclms-check-answer-button'
		)
	)));
	?>
	<div class="gclms-explanation">
		<?= $question['explanation'] ?>
	</div>
</div>