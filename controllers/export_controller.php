<?
class ExportController extends AppController {
    var $uses = array('Node','Textarea');

    function beforeRender() {
		$this->defaultBreadcrumbsAndLogo();
		$this->Breadcrumbs->addCrumb('Export','/' . $this->viewVars['groupAndCoursePath'] . '/export');

    	parent::beforeRender();
    }
	
	function index() {}
	
	function odt() {
		App::import('Vendor', 'open_document'. DS . 'open_document');

		$openDocument = new OpenDocument;
		$openDocument->mediaDirectory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		$openDocument->imagePrefix = $this->viewVars['groupAndCoursePath'] . '/files/';
		$openDocument->destinationFile = ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'export' . DS . $this->viewVars['course']['id'] . '.odt';
		
		// Title page
		
		// Table of contents		
		
		// Node structure
			
		$this->Node->contain('Textarea');
		$nodes = $this->Node->findAll(array('Node.course_id' => $this->viewVars['course']['id']),null,'Node.order ASC');

		foreach($nodes as $node) {
			$openDocument->importHTML('<h1>' . $node['Node']['title'] . '</h1>');
			foreach($node['Textarea'] as $textarea) {
				$openDocument->importHTML($textarea['content']);
			}
		}

		/*
		
		// Articles
		
		App::import('Model','Article');
		$this->Article = new Article;
		
		$articles = $this->Article->findAll(array('Article.course_id' => $this->viewVars['course']['id']),null,'Article.title ASC');
		
		foreach($articles as $article) {
			$openDocument->importHTML('<h1>' . $article['Article']['title'] . '</h1>');
			$openDocument->importHTML($article['Article']['content']);
		}
	
		// Glossary
		
		App::import('Model','GlossaryTerm');
		$this->GlossaryTerm = new GlossaryTerm;
		
		$glossary_terms = $this->GlossaryTerm->findAll(array('GlossaryTerm.course_id' => $this->viewVars['course']['id']),null,'GlossaryTerm.term ASC');
		
		$openDocument->importHTML('<h1>' . __('Glossary',true) . '</h1>');
		foreach($glossary_terms as $glossary_term) {
			$openDocument->importHTML('<h2>' . $glossary_term['GlossaryTerm']['term'] . '</h2>');
			$openDocument->importHTML($glossary_term['GlossaryTerm']['description']);
		}
		
		// Books
		
		*/
		
		$openDocument->save($openDocument->destinationFile);
		
		if(!file_exists($openDocument->destinationFile))
			die('There was an error in the export.');
			
		header('Content-type: application/vnd.oasis.opendocument.text');	
		header('Content-Disposition: attachment; filename="' . $this->viewVars['course']['title'] . '.odt"');
		header("Content-Length: " .  filesize($openDocument->destinationFile));
		header("Content-Transfer-Encoding: binary\n");
		
		readfile($openDocument->destinationFile);
	}
}