<div class="gclms-multiple-choice"
	question:triesLeft="3"
	question:defaultTryAgainMessage="<? __('Incorrect. Try again.') ?>"
	question:defaultPartiallyCorrectMessage="<? __('You are partially correct. Try again.') ?>"
	question:defaultCorrectMessage="<? __('Correct!') ?>"
	question:defaultNoMoreIncorrectTriesMessage="<? __('You are out of tries. The correct answer is shown.') ?>"
	>
	<h5><?= $question['title'] ?></h5>
	<ul class="gclms-answers">
	<?
	$correctAnswers = 0;
	foreach($question['Answer'] as $answer) {
		if($answer['correct'])
			$correctAnswers++;
	}
	
	$uniqueQuestionName = String::uuid();
	shuffle($question['Answer']);
	
	if($correctAnswers > 1) {
		foreach($question['Answer'] as $answer) {
			$text = $answer['text1'];
			$correct = $answer['correct'] ? 'true' : 'false';
			$id = String::uuid();
			echo "<li><p><input type='checkbox' answer:correct='$correct' id='$id'/><label for='$id'> " . strip_tags($text,'<a><em><b>')  . "</label></p></li>";
			if($answer['correct'])
				$correctAnswers++;
		}
	} else {
		foreach($question['Answer'] as $answer) {
			$uniqueAnswerName = String::uuid();
			$text = $answer['text1'];
			echo '<li><p>'
				. '<input type="radio" name="' . $uniqueQuestionName . '"  id="' . $uniqueAnswerName . '"'
				. 'answer:correct="' . ($answer['correct'] ? 'true' : 'false') . '" />'
				. '<label for="' . $uniqueAnswerName . '"> ' . strip_tags($text,'<a><em><b>') . '</label></p></li>';
			if($answer['correct'])
				$correctAnswers++;
		}
	}
	?>
	</ul>
	<p>
		<button class="checkAnswerButton"><? __('Check answer') ?></button>
	</p>
</div>