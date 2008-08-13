<?
$translatedPhrases->add('Incorrect. Try again.',__('Incorrect. Try again.',true));
$translatedPhrases->add('You are partially correct. Try again.',__('You are partially correct. Try again.',true));
$translatedPhrases->add('Correct!',__('Correct!',true));
$translatedPhrases->add('You are out of tries. The correct answer is shown.',__('You are out of tries. The correct answer is shown.',true));

$correctAnswers = array();
foreach($question['Answer'] as $answer) {
	if($answer['correct'])
		$correctAnswers[] = $answer['id'];
}
?>
<div class="gclms-multiple-choice" gclms:tries-remaining="3" gclms:correct-answers="<?= str_replace('"',"'",$javascript->object($correctAnswers)); ?>">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<ul class="gclms-answers">
	<?
	$uniqueQuestionName = String::uuid();
	shuffle($question['Answer']);
	
	if(sizeof($correctAnswers) > 1) {
		foreach($question['Answer'] as $answer) {
			$text = $answer['text1'];
			$correct = $answer['correct'] ? 'true' : 'false';
			$id = String::uuid();
			echo "<li><p><input type='checkbox' gclms:correct-answer='$correct' id='$id'/><label for='$id'> " . strip_tags($text,'<a><em><b>')  . "</label></p></li>";
			if($answer['correct'])
				$correctAnswers++;
		}
	} else {
		foreach($question['Answer'] as $answer) {
			$uniqueInputId = String::uuid();
			$text = $answer['text1']; ?>
			<li gclms:answer-id="<?= $answer['id'] ?>">
				<p>
					<input type="radio" id="<?= $uniqueInputId ?>" name="<?= $question['id'] ?>" />
					<label for="<?= $uniqueInputId ?>"><?= strip_tags($text,'<a><em><b>') ?></label>
				</p>
				<div class="gclms-explanation"><?= $answer['text3'] ?></div>
			</li><?
		}
	}
	?>
	</ul>
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