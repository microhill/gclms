<div class="questions <?= $page['Page']['grade_recorded'] ? 'gradedAssessment' : 'selfCheck' ?>">
<?
foreach($page['Question'] as $question) {
	switch($question['type']){
		case 0: //Multiple choice
			echo $this->element('question_multiple_choice',array('question'=>$question));
			break;
		case 1: //True/false
			echo $this->element('question_true_false',array('question'=>$question));
			break;
		case 2: //Fill in the blank
			echo $this->element('question_fill_in_the_blank',array('question'=>$question));
			break;
		case 3: //Matching
			echo $this->element('question_matching',array('question'=>$question));
			break;
	}
}

if($page['Page']['grade_recorded']): ?>
	<!-- p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p -->
<? endif; ?>
</div>