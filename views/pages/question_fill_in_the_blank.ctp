<div class="gclms-fill-in-the-blank"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h5><?= $question['title'] ?></h5>
	<p>
		<input type="text" correctAnswer:text="<?= $question['text_answer'] ?>" />
	</p>
	<p>
		<div id="gclms-<?= $question['id'] ?>-answers" class="gclms-hidden">
			<? foreach($question['Answer'] as $answer): ?>
				<span><?= $answer['text1'] ?></span>
			<? endforeach; ?>
		</div>
	</p>
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