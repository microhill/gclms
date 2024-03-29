<?
if(isset(Group::get('web_path')))
	$myPaginator->options(array('url'=>array('group'=>@Group::get('web_path'),'courses'=>null)));	

$headers = array(
	$myPaginator->sort(__('Name',true),'name'),
	$myPaginator->sort(__('Language',true),'language')
);
$fields = array('Course.name', 'Course.language');

function customizeCellData($row,$helpers) {
	return $row;
}

function customizeRowURL($row,$url) {
	unset($url['id']);
	$url['controller'] = null;
	$url['action'] = '';
	$url['courses'] = $row['Course']['web_path'];

	return Router::url($url);
}

echo $this->element('recordset',array(
	'headers' => $headers,
	'heading' => __('Course Catalogue', true),
	'showDefaultAddButton' => false,
	'fields' => $fields
));