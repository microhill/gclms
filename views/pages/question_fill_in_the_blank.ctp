<?
$translatedPhrases->add('Incorrect. Try again.',__('Incorrect. Try again.',true));
$translatedPhrases->add('Correct!',__('Correct!',true));
$translatedPhrases->add('You are out of tries. The correct answer is shown.',__('You are out of tries. The correct answer is shown.',true));

$correct_answers = Set::extract($question['Answer'], '{n}.text1');
?>
<div class="gclms-fill-in-the-blank" gclms:tries-remaining="3" gclms:correct-answers="<?= str_replace('"',"'",$javascript->object($correct_answers)); ?>">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<p>
		<input type="text"/>
	</p>
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