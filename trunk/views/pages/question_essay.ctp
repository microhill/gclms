<div class="gclms-essay-question">
	<h5><?= strip_tags($question['title'],'<a><em><b>') ?></h5>
	<textarea></textarea>
	<p>
		<?= $this->element('buttons',array('buttons' => array(
			array(
				'text' => __('Check answer',true),
				'class' => 'gclms-check-answer-button'
			)
		)));
		?>
	</p>
	<div class="gclms-explanation">
		<?= $question['explanation'] ?>
	</div>
</div>