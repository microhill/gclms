<?php
class NotebookEntryComment extends AppModel {
	var $belongsTo = array('NotebookEntry','User');
	
	function beforeSave() {
		App::import('Vendor','HTMLPurifier',array('file'=>'htmlpurifier/HTMLPurifier.standalone.php'));
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML', 'Allowed', 'p,b,i,strong,em,ul,ol,li,blockquote');
			
		$purifier = new HTMLPurifier($config);
		
		$this->data['NotebookEntryComment']['content'] = $purifier->purify($this->data['NotebookEntryComment']['content']);
		
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