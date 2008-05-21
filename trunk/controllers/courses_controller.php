<?
class CoursesController extends AppController {
    var $uses = array('Course','Group','Node','ClassEnrollee','Announcement','GlossaryTerm','Article','GlossaryTerm','Book','Node');
	var $helpers = array('Time','MyTime','Scripturizer','Glossary','License');
	var $itemName = 'Course';

	function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		parent::beforeRender();
	}
	
	function delete() {
        parent::delete($this->viewVars['course']['id']);
	}
	
	function recent() {
        $this->Course->contain(array('Group' => array('web_path')));
		
		if(empty($this->viewVars['group'])) {
			$this->data = $this->Course->findall(null,null,'Course.created DESC',10);
		} else {
			$this->data = $this->Course->findall(array('Course.group_id' => $this->viewVars['group']['id']),null,'Course.created DESC',10);
		}
		
		$this->RequestHandler->isRss();
	}

	function index() {
		$this->RequestHandler->isRss();

		if(isset($this->params['course'])) {
	       	if(isset($this->passedArgs['file'])) {
				$this->file();
	       	} else {
	       		$this->show();
	       	}
	    } else {
		    //List out all courses by group
		    $this->Group->contain(array('Course'));
		    $groups = $this->Group->findAll();
		    $this->set(compact('groups'));
	    }

				//$this->lesson();
				//$this->lessonItems();
				//$this->render('lesson');
	}

	function links() {
		//Articles
		$this->Article->contain();
		$articles = $this->Article->findAllByCourseId($this->viewVars['course']['id']);
		$this->set(compact('articles'));

		//Pages
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		
		$this->set(compact('nodes'));		

		//Books
		$this->Book->contain('Chapter');
		$books = $this->Book->findAllByCourseId($this->viewVars['course']['id']);
		$this->set(compact('books'));

		//Glossary
		$this->GlossaryTerm->contain();
		$terms = $this->GlossaryTerm->findAllByCourseId($this->viewVars['course']['id']);
		$this->set(compact('terms'));

		$this->render('links','tinymce_popup');
	}

	function edit() {
		$this->Common->edit($this->viewVars['course']['id']);
	}

	function lessonHeader() {
		$this->render('lesson_header','lesson_header');
	}

	function classroom() {
		$this->lessonNavigation();

		if(isset($this->passedArgs['page'])) {
			$this->Page->contain(array('Textarea','Question' => 'Answer'));
			$page = $this->Page->findById($this->passedArgs['page']);
			$this->page($page);
		} else {
			$page = $this->Page->findFirstInLesson($this->viewVars['lesson']['id']);
			if(empty($page))
				die(__('Could not find first topic or page in lesson. Perhaps topics and pages haven\'t been created yet for this lesson?',true));
		}

		$this->set(compact('page'));

		$glossary_terms = $this->GlossaryTerm->findAll(array('course_id'=>$this->viewVars['course']['id']),array('term'));
		$glossary_terms = Set::extract($glossary_terms, '{n}.GlossaryTerm.term');
		$this->set('glossary_terms',$glossary_terms);


		$this->set('lesson_order_in_course',$this->passedArgs['lesson']);
		$this->render('classroom','classroom');
	}

	function lessonNavigation() {
		$this->Unit->contain();
		$units = $this->Unit->findAll(array("Unit.course_id" => $this->viewVars['course']['id']),null,'Unit.order ASC');
		$this->set(compact('units'));

		$this->Lesson->contain();
		$lessons = $this->Lesson->findAll(array("Lesson.course_id" => $this->viewVars['course']['id']),null,'Lesson.order ASC');
		$this->set(compact('lessons'));

		$lesson = $this->Lesson->findByOrderInCourse($this->viewVars['course']['id'],$this->passedArgs['lesson']);
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

	function enroll($id) {
		$data = array('ClassEnrollee' => array('virtual_class_id' => (int) $id,'user_id' => (int) $this->viewVars['user']['id']));
		
		if(!$this->ClassEnrollee->find($data))
			$this->ClassEnrollee->save($data);

		$this->redirect($this->viewVars['groupAndCoursePath'] . '/' . $id);
	}

	function lessonItems() {
		$page = $this->Page->findById($this->passedArgs['page']);
		$this->set('page', $page);

		$this->lessonItem();
	}

	function lessonItem() { // this method needs refactoring
		if(isset($this->passedArgs['page'])) {
			$this->Page->contain(array('Textarea','Question' => 'Answer'));
			$page = $this->Page->findById($this->passedArgs['page']);
			$this->page($page);
		} else if(@$this->passedArgs['item'] == 'first') {
			$page = $this->Page->findFirstInLesson($this->viewVars['lesson']['id']);
			if(empty($page))
				die(__('Could not find first topic or page in lesson. Perhaps topics and pages haven\'t been created yet for this lesson?',true));

			$this->page($page);
		}

		exit;
	}

	function lesson() {
		$this->Lesson->unbindModel(array('belongsTo' => array('Course'),'hasMany' => array('Page','Slideshow','Assessment')));
		$lesson = $this->Lesson->find(array('Lesson.order' => $this->passedArgs['lesson'], 'Lesson.course_id' => $this->viewVars['course']['id']));
		$this->set('lesson', $lesson['Lesson']);
	}

	function tests() {
		$tests = $this->Test->findAll(array("Test.course_id" => $this->viewVars['course']['id']));
		$this->set('tests', $tests);
		$this->render('tests');
	}

	function table() {
		$data = $this->paginate();
		$this->set(compact('data'));
	}

	function show() {		
		$this->Node->contain();
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		if(empty($this->viewVars['facilitated_class']['id'])) {
			/*
			$this->FacilitatedClass->contain();
			$facilitated_classes = $this->FacilitatedClass->findAllByCourseId($this->viewVars['course']['id']);
			$this->set('facilitated_classes',$facilitated_classes);
			*/
		} else {
			$this->Announcement->contain();
			$news_items = $this->Announcement->findAllByFacilitatedClassId($this->viewVars['facilitated_class']['id']);
			$this->set('news_items',$news_items);
		}

		$this->set('title',$this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('Site.name'));

		$this->render('description');
	}

	function afterSave() {
		$this->redirect('/' . $this->params['group'] . '/' . stringToSlug($this->data['Course']['web_path']));
		exit;
	}
}