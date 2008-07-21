<?
class ClassroomController extends AppController {
    var $uses = array('Course','Group','VirtualClass','ClassEnrollee','Node');
	var $helpers = array('Scripturizer','Glossary','License');
	var $components = array('MyAuth');

	function beforeRender() {
		$this->Breadcrumbs->addHomeCrumb();
		parent::beforeRender();
	}
	
	function framed() {
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		$this->render('framed','classroom');
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
		
		$book_count = $this->Book->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('book_count',$book_count);
		
		$article_count = $this->Article->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('article_count',$article_count);
		
		$glossary_term_count = $this->GlossaryTerm->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('glossary_term_count',$glossary_term_count);

		//$this->set('lesson_order_in_course',$lessonNumber);
		$this->render('lesson','classroom');
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