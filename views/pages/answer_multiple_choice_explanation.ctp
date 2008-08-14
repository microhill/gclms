<?
echo $form->input('Question' . $question_id . 'MatchingAnswer' . $answer_id . 'text3',array(
	'label' =>  false,
	'cols' => 40,
	'rows' => 10,
	'div' => false,
	'value' => @$answer['text3'],
	'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][text3]",
	'class' => 'gclms-answer-explanation'
));