<?php
class NotebookEntry extends AppModel {
	var $belongsTo = array('Course','User');
	
	function beforeSave() {
		App::import('Vendor','HTMLPurifier',array('file'=>'htmlpurifier/HTMLPurifier.standalone.php'));
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML', 'Allowed', 'p,b,i,strong,em,ul,ol,li,blockquote');
			
		$purifier = new HTMLPurifier($config);
		
		$this->data['NotebookEntry']['title'] = $purifier->purify($this->data['NotebookEntry']['title']);
		$this->data['NotebookEntry']['content'] = $purifier->purify($this->data['NotebookEntry']['content']);
		
		return true;
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		),
		'content' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}