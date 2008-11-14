<?
$myPaginator->options(array('url' => '/administration/groups/index'));	

$headers = array(
	$myPaginator->sort(__('Name',true),'name'),
	$myPaginator->sort(__('Web path',true),'web_path')
);
$fields = array('Group.name','Group.web_path');

function customizeCellData($row,$helpers) {		
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/administration/groups/edit/' . $row['Group']['id'] . '/';
}

echo $this->element('recordset2',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => 'Groups',
	'data' => $this->data
));