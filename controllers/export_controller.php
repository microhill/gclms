<?
class ExportController extends AppController {
    var $uses = array('Node','Textarea');

	function index() {}
	
	function odt() {
		App::import('Vendor', 'open_document'. DS . 'open_document');

		$test = new OpenDocument;
			
		$this->Node->contain('Textarea');
		$nodes = $this->Node->findAll(array('Node.course_id' => $this->viewVars['course']['id']),null,'Node.order ASC');

		foreach($nodes as $node) {
			foreach($node['Textarea'] as $textarea) {
				$test->importHTML($textarea['content']);
			}
		}
		
		$destinationFile = ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'export' . DS . 'course.odt';
		$test->save('test.odt');
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