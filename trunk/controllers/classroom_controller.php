<?
class ClassroomController extends AppController {
    var $uses = array('Course','Group','Lesson','Unit','FacilitatedClass','Page','ClassEnrollee','Announcement','DictionaryTerm','Article','DictionaryTerm','Textbook');
	var $helpers = array('Scripturizer','Dictionary','Notebook','License');
	var $components = array('MyAuth');

	function beforeRender() {
		if($this->action == 'lesson') {
			$this->Breadcrumbs->addStudentCenterCrumb();
			$this->Breadcrumbs->addGroupCrumb();
			$this->Breadcrumbs->addCourseCrumb();
			$this->Breadcrumbs->addLessonCrumb();
		}

		parent::beforeRender();
	}

	function lesson($lessonId) {
		$lesson = $this->Lesson->findById($lessonId);
		
		$this->set('lesson', $lesson['Lesson']);

		if($this->params['isAjax']) {
			if(!empty($this->passedArgs['page']))
				$this->page($this->passedArgs['page']);	
			
			$this->lessonNavigationPages($lessonId);
		}

		$this->lessonNavigation($lessonId);

		if(isset($this->passedArgs['page'])) {
			$page = array('Page' => array('id' => $this->passedArgs['page']));
		} else {
			$page = $this->Page->findFirstInLesson($this->viewVars['lesson']['id']);
			if(empty($page['Page']['id']))
				die(__('Could not find first topic or page in lesson. Perhaps topics and pages haven\'t been created yet for this lesson?',true));
		}
		$this->set(compact('page'));
		
		$textbook_count = $this->Textbook->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('textbook_count',$textbook_count);
		
		$article_count = $this->Article->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('article_count',$article_count);
		
		$dictionary_term_count = $this->DictionaryTerm->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('dictionary_term_count',$dictionary_term_count);

		//$this->set('lesson_order_in_course',$lessonNumber);
		$this->render('lesson','classroom');
	}

	function page($page) {
		if(is_string($page) || is_int($page)) {
			$this->Page->contain(array('Textarea','Question' => 'Answer'));
			$page = $this->Page->findById($page);
		}
		
		$this->set(compact('page'));

		$dictionary_terms = $this->DictionaryTerm->findAll(array('course_id'=>$this->viewVars['course']['id']),array('term'));
		$dictionary_terms = Set::extract($dictionary_terms, '{n}.DictionaryTerm.term');
		$this->set('dictionary_terms',$dictionary_terms);

		$this->render('page','page');
		exit;
	}
	
	function lessonNavigation($lessonId) {
		$this->Unit->contain();
		$units = $this->Unit->findAll(array("Unit.course_id" => $this->viewVars['course']['id']),null,'Unit.order ASC');
		$this->set(compact('units'));

		$this->Lesson->contain();
		$lessons = $this->Lesson->findAll(array("Lesson.course_id" => $this->viewVars['course']['id']),null,'Lesson.order ASC');
		$this->set(compact('lessons'));

		$lesson = $this->Lesson->findById($lessonId);
		$this->set('current_lesson',$lesson['Lesson']);

		$this->Page->contain();
		$topics = $this->Page->findAll(array('Page.lesson_id' => $lesson['Lesson']['id'],'Page.topic_head' => 1),null,'Page.order ASC');
		$this->set(compact('topics'));

		if(!empty($topics)){
			foreach($topics as $topic) {
				$categorizedPages[$topic['Page']['id']] = $this->Page->findAllByLessonAndTopic($lesson['Lesson']['id'],$topic['Page']['id']);
			}
		}
		$uncategorizedPages = $this->Page->findAllByLessonAndTopic($lesson['Lesson']['id'],0);

		$this->set('categorized_pages',@$categorizedPages);
		$this->set('uncategorized_pages',$uncategorizedPages);
	}
	
	function lessonNavigationPages($lessonId) {
		$this->Lesson->contain();
		$lessons = $this->Lesson->findAll(array("Lesson.course_id" => $this->viewVars['course']['id']),null,'Lesson.order ASC');
		$this->set(compact('lessons'));

		$lesson = $this->Lesson->findById($lessonId);
		$this->set('current_lesson',$lesson['Lesson']);

		$this->Page->contain();
		$topics = $this->Page->findAll(array('Page.lesson_id' => $lesson['Lesson']['id'],'Page.topic_head' => 1),null,'Page.order ASC');
		$this->set(compact('topics'));

		if(!empty($topics)){
			foreach($topics as $topic) {
				$categorizedPages[$topic['Page']['id']] = $this->Page->findAllByLessonAndTopic($lesson['Lesson']['id'],$topic['Page']['id']);
			}
			$this->set('categorized_pages',@$categorizedPages);
		} else {
			$uncategorizedPages = $this->Page->findAllByLessonAndTopic($lesson['Lesson']['id'],0);
			$this->set('uncategorized_pages',@$uncategorizedPages);
		}
		
		$this->render('lessonNavigationPages','blank');
		exit;
	}
}