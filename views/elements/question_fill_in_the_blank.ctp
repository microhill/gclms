<div class="fillInTheBlank"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h3><?= $question['title'] ?></h3>
	<p>
		<input type="text" correctAnswer:text="<?= $question['fill_in_the_blank_answer'] ?>" />
	</p>
	<p>
		<button class="checkAnswerButton"><? __('Check answer') ?></button>
	</p>
</div>