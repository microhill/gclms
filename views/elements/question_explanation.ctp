<?
echo $form->input('Question' . $question_id . 'explanation',array(
	'label' =>  false,
	'cols' => 40,
	'rows' => 10,
	'div' => false,
	'value' => @$question['explanation'],
	'name' => "data[Question][$question_id][explanation]",
	'class' => 'gclms-question-explanation gclms-tinymce-enabled'
));