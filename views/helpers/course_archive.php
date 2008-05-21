<?
uses('Folder');
App::import('Vendor','Archive');

class CourseArchiveHelper extends AppHelper {
	function export($data) {
		$this->view =& ClassRegistry::getObject('view');
		
		$this->data = $data;
		$destinationFile = TMP . 'export' . DS . $this->data['course']['id'] . '.zip';
		
		//Open archive, or create archive if at first stage
		$this->archive = new Archive($destinationFile,$data['stage'] == 0);

		if($data['stage'] < count($data['nodes'])) {
			$this->export_page($data['nodes'][$data['stage']]);	
		} else {
			$postNodesStage = $data['stage'] - count($data['nodes']);
			
			switch($postNodesStage) {
				case 0:
					$folder = new Folder(WWW_ROOT . 'js');
					$files = $folder->findRecursive('.*js');
					foreach($files as $file) {
						$this->archive->addFile(str_replace(WWW_ROOT,'',$file),$file);
					}
					break;
				case 1:
					$folder = new Folder(WWW_ROOT . 'img');
					$files = $folder->findRecursive('.*(jpg|gif|png)');
					foreach($files as $file) {
						$this->archive->addFile(str_replace(WWW_ROOT,'',$file),$file);
					}
					break;
				case 2:
					$folder = new Folder(WWW_ROOT . 'css');
					$files = $folder->find('.*css');
					foreach($files as $file) {
						$this->archive->addFile('css/' . $file,WWW_ROOT . 'css' . DS . $file);
					}
					
					$this->archive->write($data['group']['web_path'] . '/' . $data['course']['web_path'] . '/index.html');
					break;
				case 3:
					$folder = new Folder(ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $data['course']['id']);
					$files = $folder->find('.*');
					foreach($files as $file) {
						$this->archive->addFile($data['group']['web_path'] . '/' . $data['course']['web_path'] . '/files/' . $file,ROOT . DS . APP_DIR . DS . 'files' . DS . 'courses' . DS . $data['course']['id'] . DS . $file);
					}	
					break;
				case 4:
					$this->archive->write($data['group']['web_path'] . '/' . $data['course']['web_path'] . '/index.html',$this->view->element('offline_course',array(
						'nodes' => $data['nodes'],
						'title_for_layout' => 'test',
						'offline' => true
					)));
					break;
			}	
		}
		
		return array(
			'stage' => $data['stage'],
			'totalStages' => count($data['nodes']) + 4
		);
	}
	
	function export_page($node) {
		if($node['type'] == '0') {
			$this->archive->write($this->data['group']['web_path'] . '/' . $this->data['course']['web_path'] . '/pages/view/' . $node['id'] . '.html',$this->view->element('offline_page',array(
				'node' => $node,
				'title_for_layout' => 'test',
				'offline' => true
			)));
		}
		
		if(empty($node['ChildNode'])) {
			return true;
		}

		foreach($node['ChildNode'] as $childNode) {
			$this->export_page($childNode);
		}
	}
}