<div class="orderQuestion"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultPartiallyCorrectMessage="<? __('You are partially correct. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h2><?= $question['title'] ?></h2>
	<ul class="answers" id="<?= String::uuid() ?>">
	<?
	shuffle($question['Answer']);
	
	foreach($question['Answer'] as $answer) {
		$text = $answer['text1'];
		echo "<li gclms:question-id='" . $answer['id'] . "' gclms:answer-order='" . $answer['order'] . "'>$text</li>";
	}
	?>
	</ul>
	<p>
		<button class="checkAnswerButton"><? __('Check answer') ?></button>
	</p>
</div>