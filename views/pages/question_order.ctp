<?
$translatedPhrases->add('Incorrect. Try again.',__('Incorrect. Try again.',true));
$translatedPhrases->add('You are partially correct. Try again.',__('You are partially correct. Try again.',true));
$translatedPhrases->add('Correct!',__('Correct!',true));
$translatedPhrases->add('You are out of tries. The correct answer is shown.',__('You are out of tries. The correct answer is shown.',true));

$answer_ids = Set::extract($question['Answer'], '{n}.id');
$answer_orders = Set::extract($question['Answer'], '{n}.order');
array_walk($answer_orders,'to_int');
$answers = array_combine($answer_orders,$answer_ids);
?>
<div class="gclms-order-question" gclms:tries-left="3" gclms:answer="<?= $javascript->object($answers); ?>">
	<h5><?= $question['title'] ?></h5>
	<ul class="gclms-answers" id="<?= String::uuid() ?>">
	<?
	shuffle($question['Answer']);
	
	foreach($question['Answer'] as $answer) {
		$text = $answer['text1'];
		echo "<li gclms:question-id='" . $answer['id'] . "' gclms:answer-order='" . $answer['order'] . "'>$text</li>";
	}
	?>
	</ul>
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