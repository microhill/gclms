<?
$myPaginator->options(array('url' => '/administration/users/index'));	

$headers = array(
	$myPaginator->sort(__('First Name',true),'first_name'),
	$myPaginator->sort(__('Last Name',true),'last_name'),
	$myPaginator->sort(__('Email',true),'email')
);
$fields = array('User.first_name','User.last_name','User.email');

function customizeRowURL($row,$defaultUrl) {
	return '/administration/users/edit/' . $defaultUrl['id'];
}

function customizeCellData($row,$helpers) {
	return $row;
}

echo $this->renderElement('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => 'Users',
	'data' => $data
));