<div class="gclms-essay-question" gclms:question-id="<?= $question['id'] ?>">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<textarea cols="30" rows="10" id="<?= String::uuid() ?>"><?= @$question['response'] ?></textarea>
	<? if(!empty($question['explanation'])): ?>
		<div class="gclms-explanation">
			<?= $question['explanation'] ?>
		</div>
		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Save and check answer',true),
				'class' => 'gclms-check-answer-button'
			)
		)));
		?>
	<? else: ?>
		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Save',true),
				'class' => 'gclms-save-answer-button'
			)
		)));
		?>
	<? endif; ?>
</div>