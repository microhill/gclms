<?php
/*
 * Question.type: 0 => Multiple choice, 1 => True/false, 2 => Matching, 3=> Ordered List, 4 => Fill in the blank, 5 => Essay
 */

class Question extends AppModel {
    var $belongsTo = array('Node');
    var $hasMany = array('Answer');
	
	function saveAnswers($questionData) {
		$this->deleteRemovedAnswers($questionData);

		if(isset($questionData['MultipleChoiceAnswer']) && $questionData['type'] == '0') {
			foreach($questionData['MultipleChoiceAnswer'] as $answer) {
				$this->deleteRemovedAnswers($this->id,$questionData);
				$answer['question_id'] = $this->id;
				$this->Answer->save($answer);
				$this->Answer->id = null;
			}
		} else if(isset($questionData['MatchingAnswer']) && $questionData['type'] == '2') {
			foreach($questionData['MatchingAnswer'] as $answer) {
				$answer['question_id'] = $this->id;
				$this->Answer->save($answer);
				$this->Answer->id = null;
			}
		} else if(isset($questionData['OrderAnswer']) && ($questionData['type'] == '3' || $questionData['type'] == '4')) {
			foreach($question['OrderAnswer'] as $answer) {
				$answer['question_id'] = $this->id;
				$this->Answer->save($answer);
				$this->Answer->id = null;
			}
		}
	}
	
	function deleteRemovedAnswers($questionData) {
		switch($questionData['type']) {
			case '0':
				$type = 'MultipleChoice';
				break;
			case '2':
				$type = 'Matching';
				break;
			case '3':
				$type = 'Order';
				break;
			default:
				return true;
				break;
		}
		
		$questionData['type'] == '0';

		App::import('Model','Answer');
		$this->Answer = new Answer;
		
		$this->Answer->contain();		
		$existingAnswerIds = Set::extract($this->Answer->findAll(array('question_id' => $questionData['id']),array('id')), '{n}.Answer.id');
	
		if(empty($questionData[$type . 'Answer']))
			$questionData[$type . 'Answer'] = array();
			
		$newAnswerIds = array_keys($questionData[$type . 'Answer']);
		$deletedAnswerIds = array_diff($existingAnswerIds,$newAnswerIds);
	
		foreach($deletedAnswerIds as $answerId) {
			$this->Answer->id = $answerId;
			$this->Answer->delete();
		}
	}
}