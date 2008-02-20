<?php
/*
 * Question.type: 0 => Multiple choice, 1 => True/false, 2 => Fill in the blank, 3 => Matching
 */

class Question extends AppModel {
    var $belongsTo = array('Node');
    var $hasMany = array('Answer');

    function deleteAllInPage($pageId) {
		$questions = $this->findAllByQuestionId($pageId,array('id'));
		foreach($questions as $question) {
			$this->delete($question['Question']['id']);
		}

		return true;
    }
}