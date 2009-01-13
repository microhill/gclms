<?
class ClassroomController extends AppController {
    var $uses = array('Course','Group','VirtualClass','ClassEnrollee','Node');
	var $helpers = array('Scripturizer','Glossary','License');

	function beforeRender() {
		$this->Breadcrumbs->addHomeCrumb();
		$this->Breadcrumbs->addGroupCrumb();
		$this->Breadcrumbs->addCourseCrumb();
		parent::beforeRender();
	}
	
	function framed() {
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		$book_count = ClassRegistry::init('Book','Model')->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('book_count',$book_count);
		
		$article_count = ClassRegistry::init('Article','Model')->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('article_count',$article_count);
		
		$glossary_term_count = ClassRegistry::init('GlossaryTerm','Model')->findCount(array('course_id'=>$this->viewVars['course']['id']),0);
		$this->set('glossary_term_count',$glossary_term_count);
		
		$this->render('framed','classroom');
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