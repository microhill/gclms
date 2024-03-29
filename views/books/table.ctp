<?
$myPaginator->options(array('url' => '/' . Group::get('web_path') . '/books/course:' . $course['web_path']));

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

echo $this->element('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => 'Books',
	'data' => $data,
	'addButtonUrl' => '/' . Group::get('web_path') . '/books/add/course:' . $course['web_path']
));
?>