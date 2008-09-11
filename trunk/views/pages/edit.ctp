<?
$translatedPhrases->add('Yes',__('Yes',true));
$translatedPhrases->add('No',__('No',true));

$html->css('edit_page', null, null, false);

$javascript->link(array(
	'vendors/tinymce3.1.0.1/tiny_mce',
	'vendors/prototype',
	'vendors/client_detection',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_page'
), false);
?>
<?= $this->element('no_column_background'); ?>
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
		'url' => $groupAndCoursePath . '/pages/edit/' . $this->data['Node']['id'],
		'gclms:no-empty-question-title-message' => __('Every question must have a title.',true)
	));

	echo $form->input('title',array(
		'label' =>  __('Title', true),
		'between' => '<br/>',
		'size'=>45
	));
	?>
    <div class="gclms-top-buttons">
		<?= $this->element('buttons', array('buttons' => array(
			array(
				'text' => 'Insert Question',
				'class' => 'gclms-insert-question'
			),
			array(
				'text' => 'Insert Content',
				'class' => 'gclms-insert-textarea'
			)
		)));
		?>
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
		echo $this->element('../pages/textarea');
	} else {
		foreach($nodeItems as $pageItem) {
			if(isset($pageItem['content']))
				echo $this->element('../pages/textarea',array('textarea' => $pageItem));
			else
				echo $this->element('../pages/question',array('question' => $pageItem));
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

	echo $this->element('save_and_delete',array(
		'confirm_delete_text' => __('Are you sure you want to delete this page?',true)
	));

	echo $form->end();
	?>
</div>
<script>
    var tmpTextareaView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/textarea',array('textarea_id' => '#{id}')))); ?>;
    
    var tmpQuestionView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/question',array('question_id' => '#{id}')))); ?>;
    
    var tmpQuestionExplanationView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/question_explanation',array('question_id' => '#{id}')))); ?>;
    
    var tmpMultipleChoiceAnswerExplanationView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/answer_multiple_choice_explanation',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    )))); ?>;
    
    var tmpMultipleChoiceAnswerView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/answer_multiple_choice',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    )))); ?>;
    
    var tmpMatchingAnswerView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/answer_matching',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    )))); ?>;
    
    var tmpOrderAnswerView = <?= $javascript->object(str_replace(array("\n","\r","\t",'    '),'',$this->element('../pages/answer_order',array(
    	'question_id' => '#{question_id}',
    	'answer_id' => '#{answer_id}'
    )))); ?>;
</script>
