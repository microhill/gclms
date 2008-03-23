<?
class ExportController extends AppController {
    var $uses = array('Node','Textarea');

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Export','/' . $this->viewVars['groupAndCoursePath'] . '/export');

    	parent::beforeRender();
    }
	
	function index() {
		$this->set('title', __('Export',true) . ' &raquo; ' . $this->viewVars['course']['title'] . ' &raquo; ' . $this->viewVars['group']['name'] . ' &raquo; ' . Configure::read('Site.name'));
	}
	
	private function export_node_to_odt($node,$level = 1) {
		$this->openDocument->importHTML('<h' . $level . '>' . $node['title'] . '</h' . $level . '>');
		foreach($node['Textarea'] as $textarea) {
			$this->openDocument->importHTML($textarea['content']);
		}
		
		if(empty($node['ChildNode'])) {
			return true;	
		}
		
		foreach($node['ChildNode'] as $childNode) {
			$this->export_node_to_odt($childNode,$level + 1);
		}
	}
	
	function odt() {
		App::import('Vendor', 'open_document'. DS . 'open_document');

		$this->openDocument = new OpenDocument;
		$this->openDocument->mediaDirectory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		$this->openDocument->imagePrefix = $this->viewVars['groupAndCoursePath'] . '/files/';
		$this->openDocument->destinationFile = ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'export' . DS . $this->viewVars['course']['id'] . '.odt';
		
		// Title page
		
		// Table of contents		
		
		// Node structure
			
		$this->openDocument->appendTableOfContents();
			
		$nodes =  $this->Node->findAllInCourse($this->viewVars['course']['id'],array('Textarea'));

		foreach($nodes as $node) {
			$this->export_node_to_odt($node);
		}
		
		// Articles
		
		App::import('Model','Article');
		$this->Article = new Article;
		
		$articles = $this->Article->findAll(array('Article.course_id' => $this->viewVars['course']['id']),null,'Article.title ASC');
		
		foreach($articles as $article) {
			$this->openDocument->importHTML('<h1>' . $article['Article']['title'] . '</h1>');
			$this->openDocument->importHTML($article['Article']['content']);
		}
	
		// Glossary
		
		App::import('Model','GlossaryTerm');
		$this->GlossaryTerm = new GlossaryTerm;
		
		$glossary_terms = $this->GlossaryTerm->findAll(array('GlossaryTerm.course_id' => $this->viewVars['course']['id']),null,'GlossaryTerm.term ASC');
		
		$this->openDocument->importHTML('<h1>' . __('Glossary',true) . '</h1>');
		foreach($glossary_terms as $glossary_term) {
			$this->openDocument->importHTML('<h2>' . $glossary_term['GlossaryTerm']['term'] . '</h2>');
			$this->openDocument->importHTML($glossary_term['GlossaryTerm']['description']);
		}
		
		// Books
		
		// ...

		$this->openDocument->save($this->openDocument->destinationFile);
		
		if(!file_exists($this->openDocument->destinationFile))
			die('There was an error in the export.');
			
		header('Content-type: application/vnd.oasis.opendocument.text');	
		header('Content-Disposition: attachment; filename="' . $this->viewVars['course']['title'] . '.odt"');
		header("Content-Length: " .  filesize($this->openDocument->destinationFile));
		header("Content-Transfer-Encoding: binary\n");
		
		readfile($this->openDocument->destinationFile);
		exit; // Needed to keep .zip from being corrupted
	}
}