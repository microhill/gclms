<?
$html->css('edit_page', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'vendors/tinymce3.0.5/tiny_mce',
	'gclms',
	'vendors/uuid',
	'edit_page'
), false);
?>
<?= $this->renderElement('no_column_background'); ?>
<div class="gclms-content gclms-edit-page">
    <div class="gclms-step-back">
        <a href="<?= $groupAndCoursePath ?>/content">
            <? __('Cancel and go back') ?>
        </a>
    </div>
    <h1>
        <? __('Edit Page') ?>
    </h1>
    <?
	echo $form->create('Node', array(
		'url' => $groupAndCoursePath . '/pages/save/' . $this->data['Node']['id'],
		'gclms:no-empty-question-title-message' => __('Every question must have a title.',true)
	));

	echo $form->input('title',array(
		'label' =>  __('Title', true),
		'between' => '<br/>',
		'size'=>45
	));
	?>
    <div class="gclms-top-buttons">
        <button class="insertQuestion add">
            <? __('Insert Question') ?>
        </button>
        <button class="insertTextarea add">
            <? __('Insert Content') ?>
        </button>
    </div>
    <?
	$nodeItems = array();
	foreach($this->data['Textarea'] as $textarea) {
		$nodeItems[$textarea['order']] = $textarea;
	}

	foreach($this->data['Question'] as $question) {
		$nodeItems[$question['order']] = $question;
	}

	ksort($nodeItems);

	if(empty($nodeItems)) {
		echo $this->renderElement('textarea');
	} else {
		foreach($nodeItems as $pageItem) {
			if(isset($pageItem['content']))
				echo $this->renderElement('textarea',array('textarea' => $pageItem));
			else
				echo $this->renderElement('question',array('question' => $pageItem));
		}
	}

	echo '<p>';
	echo $form->checkbox('grade_recorded');
	echo $form->label('grade_recorded','Grade recorded');
	echo '</p>';

	if(!empty($mp3s)) {
		echo '<p>';
		echo $form->label('Node.audio_file','Audio',null);
		echo '<br/>';
		echo $form->select('Node.audio_file',$mp3s,null,array(
			'label' =>  __('Content', true)
		),false);
		echo $form->input('Node.external_audio_file',array(
			'before' => ' ',
			'label' => false,
			'div' => false,
			'size' => 50,
			'class' => 'externalAudioFile',
			'disabled' => 'disabled'
		));
		echo '</p>';
	}

	echo '<div class="submit">';
	echo $form->submit(__('Save',true),array('class'=>'Save','div'=>false));
	echo $form->submit(__('Delete',true),array('class'=>'delete','div'=>false,'confirm:text'=>__('Are you sure you want to delete this page?',true)));
	echo '</div>';

	echo $form->end();
	?>
</div>
<script>
    var tmpTextareaView = <?= $javascript->object($this->renderElement('textarea',array('textarea_id' => '#{id}'))); ?>;
    var tmpQuestionView = <?= $javascript->object($this->renderElement('question',array('question_id' => '#{id}'))); ?>;
    var tmpQuestionExplanationView = <?= $javascript->object($this->renderElement('question_explanation',array('question_id' => '#{id}'))); ?>;
    var tmpMultipleChoiceAnswerExplanationView = <?= $javascript->object($this->renderElement('answer_multiple_choice_explanation',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    ))); ?>;
    var tmpMultipleChoiceAnswerView = <?= $javascript->object($this->renderElement('answer_multiple_choice',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    ))); ?>;
    var tmpMatchingAnswerView = <?= $javascript->object($this->renderElement('answer_matching',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    ))); ?>;
</script>
