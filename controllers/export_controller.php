<?
class ExportController extends AppController {
    var $uses = array('Node','Textarea');
	var $helpers = array('OpenDocument','CourseArchive');

	/*
	function beforeFilter() {
		set_time_limit(180);
		ob_start();
		header ("Pragma: no-cache");
		header ("Content-Type:text/html");
		parent::beforeFilter();
	}
	*/

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Export','/' . $this->viewVars['groupAndCoursePath'] . '/export');
    	parent::beforeRender();
    }

	function index() {
		$this->set('title', __('Export',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('Site.name'));
	}
	
	function generate_odt($stage = 0) {
		$this->prepare_course_data($stage);
		$this->data['stage'] = $stage;
	}
	
	function odt() {
		$file = TMP . 'export' . DS . $this->viewVars['course']['id'] . '.odt';
		if(!file_exists($file))
			die('File does not exist. Generate it.');
		
		header('Content-type: application/vnd.oasis.opendocument.text');
		header('Content-Disposition: attachment; filename="' . $this->viewVars['course']['title'] . '.odt"');
		header("Content-Length: " .  filesize($file));
		header("Content-Transfer-Encoding: binary\n");
	
		readfile($file);
		exit;
	}
	
	function generate_archive($stage = 0) {
		$this->prepare_course_data($stage);
		$this->data['stage'] = $stage;		
	}
	
	function archive() {
		$file = TMP . 'export' . DS . $this->viewVars['course']['id'] . '.zip';
		if(!file_exists($file))
			die('File does not exist. Generate it.');
			
		header("Content-type: application/zip");
		header('Content-Disposition: attachment; filename="' . $this->viewVars['course']['title'] . '.zip"');
		header("Content-Length: " .  filesize($file));
		header("Content-Transfer-Encoding: binary\n");
	
		readfile($file);
		exit;
	}
	
	private function prepare_course_data($stage) {
		$file = new File(TMP.'export' . DS . $this->viewVars['course']['id'] . '.tmp', true);
		
		if($stage) {
			$this->data = unserialize($file->read());
		} else {
			$this->data = array();
			
			App::import('Model','Node');
			$this->Node = new Node;
			$this->data['nodes'] = $this->Node->findAllInCourse($this->viewVars['course']['id'],array('Textarea','Question'=>'Answer'));
			$this->data['node_count'] = $this->Node->find('count',array('conditions' => array('Node.course_id' => $this->viewVars['course']['id'])));
			$this->Node->setNextAndPreviousInNodeTree(&$this->data['nodes']);
	
			App::import('Model','Article');
			$this->Article = new Article;
			$this->data['articles'] = $this->Article->findAll(array('Article.course_id' => $this->viewVars['course']['id']),null,'Article.title ASC');
	
			App::import('Model','GlossaryTerm');
			$this->GlossaryTerm = new GlossaryTerm;
			$this->data['glossary_terms'] = $this->GlossaryTerm->findAll(array('GlossaryTerm.course_id' => $this->viewVars['course']['id']),null,'GlossaryTerm.term ASC');	
		
			$file->write(serialize($this->data));
		}		
	}
}