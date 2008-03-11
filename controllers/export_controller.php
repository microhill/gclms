<?
class ExportController extends AppController {
    var $uses = array('Node','Textarea');

	function index() {}
	
	function odt() {
		App::import('Vendor', 'open_document'. DS . 'open_document');

		$openDocument = new OpenDocument;
		$openDocument->mediaDirectory = ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $this->viewVars['course']['id'];
		$openDocument->imagePrefix = $this->viewVars['groupAndCoursePath'] . '/files/';
		$openDocument->destinationFile = ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'export' . DS . $this->viewVars['course']['id'] . '.odt';
			
		$this->Node->contain('Textarea');
		$nodes = $this->Node->findAll(array('Node.course_id' => $this->viewVars['course']['id']),null,'Node.order ASC');

		foreach($nodes as $node) {
			foreach($node['Textarea'] as $textarea) {
				$openDocument->importHTML($textarea['content']);
			}
		}
		
		$openDocument->save($openDocument->destinationFile);
		
		if(!file_exists($openDocument->destinationFile))
			die('There was an error in the export.');
			
		header('Content-type: application/vnd.oasis.opendocument.text');	
		header('Content-Disposition: attachment; filename="' . $this->viewVars['course']['title'] . '.odt"');
		header("Content-Length: " .  filesize($destinationFile));
		header("Content-Transfer-Encoding: binary\n");
		
		readfile($destinationFile);
		exit;
		
//		echo $destinationFile;

		/*		
		$sourceFile = ROOT . DS . APP_DIR . DS . 'tests' . DS . 'course.html';

		DocumentConverter::convert(array(
			'sourceFile' => $sourceFile,
			'destinationFile' => $destinationFile			
		));
		*/
	}
}