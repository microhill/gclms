<div id="table">
	<?
	$myPaginator->options(array('url' => '/' . $group['web_path'] . '/textbooks/course:' . $course['web_path']));

	$headers = array(
		$myPaginator->sort(__('Title',true),'Book.title')
	);
	$fields = array('Book.title');

	function customizeCellData($row,$helpers) {
		return $row;
	}

	function customizeRowURL($row,$url) {
		return '/' . $url['group'] . '/chapters/book:' . $row['Book']['id'] . '/course:' . $row['Course']['web_path'];
	}

	echo $this->renderElement('recordset',array(
		'headers' => $headers,
		'fields' => $fields,
		'heading' => 'Textbooks',
		'data' => $data,
		'addButtonUrl' => '/' . $group['web_path'] . '/books/add/course:' . $course['web_path']
	));
	?>
</div>