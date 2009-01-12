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
		$this->Permission->cache('Course');
		if(!Permission::check('Course')) {
			$this->cakeError('permission');
		}

        parent::delete($this->viewVars['course']['id']);
	}
	
	function recent() {
        $this->Course->contain(array('Group' => array('web_path')));
		
		if(!Group::get('id')) {
			$this->data = $this->Course->findall(null,null,'Course.created DESC',10);
		} else {
			$this->data = $this->Course->findall(array('Course.group_id' => Group::get('id')),null,'Course.created DESC',10);
		}
		
		$this->RequestHandler->isRss();
	}
	
	function add() {
		$this->Permission->cache('GroupAdministration','Course');
		
		if(!Permission::check('Course')) {
			$this->cakeError('permission');
		}
	}

	function index() {
		//$this->Permission->cache('Course');
		/*
		if(!Permission::check('Course')) {
			$this->cakeError('permission');
		}
		*/

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

	function enroll($id) {
		$data = array('ClassEnrollee' => array('virtual_class_id' => (int) $id,'user_id' => (int) User::get('id')));
		
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
		$nodes = $this->Node->findAllInCourse($this->viewVars['course']['id']);
		$this->set(compact('nodes'));
		
		if(empty($this->viewVars['class']['id'])) {
			/*
			$this->FacilitatedClass->contain();
			$virtual_classes = $this->FacilitatedClass->findAllByCourseId($this->viewVars['course']['id']);
			$this->set('virtual_classes',$virtual_classes);
			*/
		} else {
			$this->Announcement->contain();
			$news_items = $this->Announcement->findAllByFacilitatedClassId($this->viewVars['class']['id']);
			$this->set('news_items',$news_items);
		}

		$this->set('title',$this->viewVars['course']['title'] . ' &raquo; ' . Group::get('name') . ' &raquo; ' . Configure::read('App.name'));

		$this->render('description');
	}

	function afterSave() {
		$this->redirect('/' . $this->params['group'] . '/' . stringToSlug($this->data['Course']['web_path']));
		exit;
	}
	
	function findAllInGroupAccessibleUser($group_id,$user_id) {
		if(User::allow(array(
			'group' => $group_id,
			'model' => 'Course',
			'action' => 'read'
		))) {
			return $this->find('all',array(
				'conditions' => array('group_id' => $group_id),
				'order' => 'Course.title ASC'
			));
		}
		
		$this->Permission &= ClassRegistry::init('Permission');
		$this->Permission->contain();
		$permissions = $this->Permission->find('all',array(
			'conditions' => array(
				'group_id' => $group_id,
				'course_id <>' => null,
				'model' => 'Node',
				'_read' => 1
			),
			'fields' => 'course_id'
		));
	}
}