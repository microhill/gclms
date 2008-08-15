<?
$translatedPhrases->add('Incorrect. Try again.',__('Incorrect. Try again.',true));
$translatedPhrases->add('Correct!',__('Correct!',true));
$translatedPhrases->add('You are out of tries. The correct answer is shown.',__('You are out of tries. The correct answer is shown.',true));

if(!empty($question['Answer'])):

$answer_ids = Set::extract($question['Answer'], '{n}.id');
?>
<div class="gclms-order-question" gclms:tries-remaining="3" gclms:correct-answer="<?= str_replace('"',"'",$javascript->object($answer_ids)); ?>">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<ul class="gclms-answers" id="<?= String::uuid() ?>">
	<?
	$originalAnswersOrder = $question['Answer'];
	do {
		shuffle($question['Answer']);
		$difference = array_diff_assoc(Set::extract($question['Answer'],'{n}.id'),Set::extract($originalAnswersOrder,'{n}.id'));
	} while(empty($difference)); //Ensures that the shuffle doesn't return the same order of items
	
	foreach($question['Answer'] as $answer) {
		$text = $answer['text1'];
		echo "<li gclms:answer-id='" . $answer['id'] . "' gclms:answer-order='" . $answer['order'] . "'>$text</li>";
	}
	?>
	</ul>
	<div class="gclms-answer-status"><span></span></div>
	<div class="gclms-explanation">
		<?= $question['explanation'] ?>
	</div>
	<?= $this->element('buttons',array('buttons' => array(
		array(
			'text' => __('Check answer',true),
			'class' => 'gclms-check-answer-button'
		)
	)));
	?>
</div>
<? endif; ?>