<?
$translatedPhrases->add('Correct! The correct answer is true.',__('Correct! The correct answer is true.',true));
$translatedPhrases->add('Correct! The correct answer is false.',__('Correct! The correct answer is false.',true));
$translatedPhrases->add('Incorrect. The correct answer is true.',__('Incorrect. The correct answer is true.',true));
$translatedPhrases->add('Incorrect. The correct answer is false.',__('Incorrect. The correct answer is false.',true));
$translatedPhrases->add('True',__('True',true));
$translatedPhrases->add('False',__('False',true));
?>
<div class="gclms-true-false" gclms:correct-answer="<?= $question['true_false_answer'] ?>">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<p>
		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('True',true),
				'class' => 'gclms-check-answer-button',
				'attributes' => array('gclms:answer-value' => 1)
			),
			array(
				'text' => __('False',true),
				'class' => 'gclms-check-answer-button',
				'attributes' => array('gclms:answer-value' => 0)
			)
		)));
		?>
	</p>
	<div class="gclms-explanation">
		<?= $question['explanation'] ?>
	</div>
</div>