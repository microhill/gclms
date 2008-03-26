<div class="gclms-true-false"
	correctAnswer:integer="<?= $question['true_false_answer'] ?>"
	correctAnswer:text="<?= empty($question['true_false_answer']) ? __('False',true) : __('True',true) ?>"
	question:defaultCorrectMessageTrue="<? __('Correct! The answer is true.') ?>"
	question:defaultCorrectMessageFalse="<? __('Correct! The answer is false.') ?>"
	question:defaultIncorrectMessageTrue="<? __('Incorrect. The answer is true.') ?>"
	question:defaultIncorrectMessageFalse="<? __('Incorrect. The answer is false.') ?>"
	correctAnswer:explanation="<? @$question['exaplanation'] ?>"
	>
	<h5><?= $question['title'] ?></h5>
	<p>
		<button answer:integer="1"><? __('True') ?></button> <button answer:integer="0"><? __('False') ?></button>
	</p>
</div>