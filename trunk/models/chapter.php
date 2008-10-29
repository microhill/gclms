<?
class Chapter extends AppModel {
    var $belongsTo = array('Book');

	function getLastOrderInBook($bookId) {
		$this->contain();
		$order = $this->find(array(
			'book_id' => $bookId
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