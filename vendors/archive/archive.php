<?
class Archive {
	function __construct($archive, $create = false) {
		$this->archive = new ZipArchive;
		
		if($create && file_exists($archive)) {
			unlink($archive);
		}
		
        if(file_exists($archive) && !$create) { 
        	$this->archive->open($archive);
        } else {
        	$this->archive->open($archive, ZipArchive::CREATE);
		}
	}
	
	public function read($filename) {
		if($this->archive->locateName($filename) !== false) {
			return $this->archive->getFromName($filename);
		}
		return false;
	}
	
	public function delete($filename) {
		if ($this->archive->locateName($filename) !== false) {
			$this->archive->deleteName($filename);
		}
	}
	
	public function write($filename, $content) {
		$this->delete($filename);
		return $this->archive->addFromString($filename, $content);
	}
	
	public function addFile($filename, $localname) {
		$this->delete($filename);
		return $this->archive->addFile($localname, $filename) or die ("Could not add file: $localname");
	}
}