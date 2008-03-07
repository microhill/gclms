<?
class PagesController extends AppController {
    var $uses = array('Node','Question','Textarea');
	var $helpers = array('Scripturizer','Dictionary','Notebook','License','Form','MyForm');
    var $itemName = 'Node';
    var $components = array('Notifications');

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		
    	parent::beforeRender();
    }
	
	function view($id) {
		$this->Node->contain(array('Question' => 'Answer','Textarea'));
		$node = $this->Node->findById($id);
		
		if($node['Node']['type'] != 0)
			die('Node is not a page.');
			
		$node['Node']['previous_page_id'] = $this->Node->findPreviousPageId($node);
		$node['Node']['next_page_id'] = $this->Node->findNextPageId($node);
			
		$this->set('node',$node);
		
		//$this->DictionaryTerm = ClassRegistry::getInstance('Model', 'DictionaryTerm');
		$this->DictionaryTerm =& ClassRegistry::init('DictionaryTerm'); 
		$dictionary_terms = $this->DictionaryTerm->findAll(array('course_id'=>$this->viewVars['course']['id']),array('term'));
		$dictionary_terms = Set::extract($dictionary_terms, '{n}.DictionaryTerm.term');
		$this->set('dictionary_terms',$dictionary_terms);
		

		
		//$this->Breadcrumbs->addCrumb($node['Node']['title'], $this->viewVars['groupAndCoursePath'] . '/pages/view/' . $this->data['Node']['id']);		
	}

	function add_textarea($textarea_id = '#{id}') {
		$this->set('textarea_id',$textarea_id);
		$this->render('textarea','ajax');
	}

    function add_question($question_id = '#{id}') {
		$this->set('question_id',$question_id);
		$this->render('question','ajax');
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
		        if ($path_parts['extension'] == 'mp3') {
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
		
		$this->set('title',$this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('Site.name'));
    }

	function save($id) {		
		$this->Node->id = $id;
		$this->Question->deleteAllInNode(array('node_id'=>$id)); // This should be done smarter!!!

		if(!empty($this->data['Node']['audio_file'])
				&& $this->data['Node']['audio_file'] == 'External URL' && !empty($this->data['Node']['external_audio_file']))
			$this->data['Node']['audio_file'] = $this->data['Node']['external_audio_file'];

		$this->data['Node']['previous_node_id'] = $this->Node->findPreviousNodeId();
		$this->data['Node']['next_node_id'] = $this->Node->findNextNodeId();

		$this->Node->save($this->data);

		if(isset($this->data['Textarea'])) {
			foreach($this->data['Textarea'] as $textarea) {
				$textarea['node_id'] = $this->Node->id;
				$this->Node->Textarea->save($textarea);
			}
		}

		$this->saveQuestions($id);

		$lessonId = $this->Node->field('lesson_id',array('id' => $id));
		$lesson = array('id' => $lessonId);
		$this->set(compact('lesson'));

		$this->afterSave();
	}

	function saveQuestions($id = null) {
		if(isset($this->data['Question'])) {
			foreach($this->data['Question'] as $question) {
				$question['node_id'] = $this->Node->id;

				$this->Node->Question->save($question);

				if(isset($question['MultipleChoiceAnswer']) && $question['type'] == '0') {
					foreach($question['MultipleChoiceAnswer'] as $answer) {
						$answer['question_id'] = $this->Node->Question->id;
						$this->Node->Question->Answer->save($answer);
						$this->Node->Question->Answer->id = null;
					}
				} else if(isset($question['MatchingAnswer']) && $question['type'] == '3') {
					foreach($question['MatchingAnswer'] as $answer) {
						$answer['question_id'] = $this->Node->Question->id;
						$this->Node->Question->Answer->save($answer);
						$this->Node->Question->Answer->id = null;
					}
				}

				$this->Node->Question->id = null;
			}
		}
	}

	function afterSave() {
		$this->redirect = '/' . $this->viewVars['group']['web_path'] . '/' . $this->viewVars['course']['web_path'] . '/content';
		parent::afterSave();
	}

    function delete($id) {
    	$this->Node->delete($id);
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