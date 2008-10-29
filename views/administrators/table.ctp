<?
$myPaginator->options(array('url' => '/administration/group_administrators/index'));	
$headers = array(
	$myPaginator->sort(__('Email',true),'email'),
	$myPaginator->sort(__('Name',true),'last_name')	
);
$fields = array('User.email','User.full_name');

function customizeCellData($row,$helpers) {
	$row['User']['full_name'] = $row['User']['first_name'] . ' ' . $row['User']['last_name'];
	
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/administration/group_administrators/edit/' . $row['User']['id'] . '/';
}

echo $this->element('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => 'Administrators',
	'data' => $data
));