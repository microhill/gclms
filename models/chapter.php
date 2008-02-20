<?php
class Chapter extends AppModel {
    var $belongsTo = array('Textbook');

	function getLastOrderInTextbook($textbookId) {
		$this->contain();
		$order = $this->find(array(
			'textbook_id' => $textbookId
		),array('order'),'Chapter.order DESC');
		if(empty($order))
			return 0;
		else
			return (int) $order['Chapter']['order'];
	}
	
	var $validate = array(
		'title' => array(
			'rule' => VALID_NOT_EMPTY
		)
	);
}