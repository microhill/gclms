<?
class PagesController extends AppController {
    var $uses = array('Node','Question','Textarea');
	var $helpers = array('Scripturizer','Glossary','MediaFiles','License','Form','MyForm','Javascript','TranslatedPhrases');
    var $itemName = 'Node';
    var $components = array('Notifications','RequestHandler');

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();

    	parent::beforeRender();
    }
	
	function view($id) {		
		$this->Breadcrumbs->addHomeCrumb();

		$this->Breadcrumbs->addGroupCrumb();
		if(!empty($this->viewVars['group']['logo']) && $this->name != 'Classroom')
			$this->set('logo',$this->viewVars['group']['logo']);

		$this->Breadcrumbs->addCrumb($this->viewVars['course']['title'],array('url' => $this->viewVars['groupAndCoursePath'],'class' => 'gclms-course-menu'));

		$this->Node->contain(array('Question' => 'Answer','Textarea'));
		$node = $this->Node->findById($id);
		
		if($node['Node']['type'] != 0)
			die('Node is not a page.');
			
		$node['Node']['previous_page_id'] = $this->Node->findPreviousPageId($node);
		$node['Node']['next_page_id'] = $this->Node->findNextPageId($node);
		//pr($node['Node']['next_page_id']);
		$this->set('node',$node);
		
		//$this->GlossaryTerm = ClassRegistry::getInstance('Model', 'GlossaryTerm');
		$this->GlossaryTerm =& ClassRegistry::init('GlossaryTerm'); 
		$glossary_terms = $this->GlossaryTerm->findAll(array('course_id'=>$this->viewVars['course']['id']),array('id','term'));
		$this->set('glossary_terms',$glossary_terms);
		
		//$this->Breadcrumbs->addCrumb($node['Node']['title'], $this->viewVars['groupAndCoursePath'] . '/pages/view/' . $this->data['Node']['id']);
		$this->set('title',$node['Node']['title'] . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name']);
	}

    function add_multiple_choice_answer($id) {
		$this->set('question_id',$id);
		$this->render('multiple_choice_answer','ajax');
    }

    function add_matching_answer($id) {
		$this->set('question_id',$id);
		$this->render('matching_answer','ajax');
    }

    function edit($id) {
		$this->defaultBreadcrumbsAndLogo();
	
		if(!empty($this->data)) {
			$this->save($id);
			exit;
		}
		
		$this->Node->contain(array('Textarea','Question' => 'Answer'));
		$page = $this->Node->findById($id);
		$this->data = $page;

		$directory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		if(!file_exists($directory))
			mkdir($directory);

		App::import('Vendor', 'mimetypehandler'.DS.'mimetypehandler');
		$mime = new MimetypeHandler();

		if($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
		        if(is_dir($directory . DS . $file))
		        	continue;
		        $path_parts = pathinfo($file);
		        if (@$path_parts['extension'] == 'mp3') {
		            $files[$file] = $file;
		        }
		    }
		    closedir($handle);
		}

		if(!empty($files)) {
			ksort($files);
			$files = am(array('' => __('None',true),'External URL' => __('External URL',true)),$files);
			$this->set('mp3s',$files);
		}

		if(substr(strtolower($this->data['Node']['audio_file']),0,7) == 'http://') {
			$this->data['Node']['external_audio_file'] = $this->data['Node']['audio_file'];
			$this->data['Node']['audio_file'] = 'External URL';
		}
		
		$this->set('title',$this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('App.name'));
    }

	function save($id) {
		$order = 1;
		
		$this->Node->id = $id;
		//$this->Question->deleteAllInNode(array('node_id'=>$id)); // This should be done smarter!!!

		if(empty($this->data['Textarea']))
			$this->data['Textarea'] = array();

		$this->Textarea->contain();
		$existingTextareaIds = Set::extract($this->Textarea->findAll(array('node_id' => $id),array('id')), '{n}.Textarea.id');

		$newTextareaIds = array_keys($this->data['Textarea']);
		$deletedTextareaIds = array_diff($existingTextareaIds,$newTextareaIds);

		foreach($deletedTextareaIds as $questionId) {
			$this->Textarea->id = $questionId;
			$this->Textarea->delete();
		}

		if(!empty($this->data['Node']['audio_file'])
				&& $this->data['Node']['audio_file'] == 'External URL' && !empty($this->data['Node']['external_audio_file']))
			$this->data['Node']['audio_file'] = $this->data['Node']['external_audio_file'];

		$this->Node->save($this->data);

		if(isset($this->data['Textarea'])) {
			foreach($this->data['Textarea'] as $textarea) {
				$textarea['node_id'] = $this->Node->id;
				$this->Node->Textarea->save($textarea);
			}
		}

		$this->saveQuestions($id);

		parent::afterSave();
	}

	function saveQuestions($id = null) {
		if(empty($this->data['Question']))
			$this->data['Question'] = array();

		$this->Question->contain();		
		$existingQuestionIds = Set::extract($this->Question->findAll(array('node_id' => $id),array('id')), '{n}.Question.id');

		$newQuestionIds = array_keys($this->data['Question']);
		$deletedQuestionIds = array_diff($existingQuestionIds,$newQuestionIds);

		foreach($deletedQuestionIds as $questionId) {
			$this->Question->id = $questionId;
			$this->Question->delete();
		}
		
		if(isset($this->data['Question'])) {
			foreach($this->data['Question'] as $question) {
				$question['node_id'] = $this->Node->id;

				$this->Node->Question->save($question);
				$this->Node->Question->saveAnswers($question);
				$this->Node->Question->id = null;
			}
		}
	}

	function afterSave() {
		$this->redirect = '/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/pages/view/' . $this->Node->id;
	}

    function delete($id) {
    	$this->Node->delete($id);
    	if(!$this->params['isAjax']) {
    		$this->afterSave();
    	}
		exit;
    }

    function rename($id) {
    	$title = $this->data['Node']['title'];
		$this->Node->id = $id;
		$this->Node->saveField('title', $title);
    	exit;
    }

    function isAuthorized() {
    	if(parent::isAuthorized())
    		return true;

    	switch($this->action) {
    		case 'display':
    			return true;
    			break;
			default:
				return true;
				break;
    	}
    }
}