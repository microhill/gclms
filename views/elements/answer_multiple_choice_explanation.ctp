<?
echo $form->input('Question' . $question_id . 'MatchingAnswer' . $answer_id . 'text2',array(
	'label' =>  false,
	'cols' => 20,
	'rows' => 10,
	'div' => false,
	'value' => @$answer['explanation'],
	'name' => "data[Question][$question_id][MultipleChoiceAnswer][$answer_id][text2]",
	'class' => 'gclms-answer-explanation'
));