<? /* <!-- div class="questions <?= $page['Page']['grade_recorded'] ? 'gradedAssessment' : 'selfCheck' ?>" --> */
switch($question['type']){
	case 0: //Multiple choice
		echo $this->element('question_multiple_choice',array('question'=>$question));
		break;
	case 1: //True/false
		echo $this->element('question_true_false',array('question'=>$question));
		break;
	case 2: //Matching
		echo $this->element('question_matching',array('question'=>$question));
		break;
	case 3: //Order
		echo $this->element('question_order',array('question'=>$question));
		break;
	case 4: //Fill in the blank
		echo $this->element('question_fill_in_the_blank',array('question'=>$question));
		break;
	case 5: //Fill in the blank
		echo $this->element('question_essay',array('question'=>$question));
		break;

}

if($node['Node']['grade_recorded']): ?>
	<!-- p id="gradeResults"><button id="gradeQuestions"><? __('Grade') ?></button></p -->
<? endif; ?>
<!--/div-->