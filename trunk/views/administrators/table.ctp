<?
$myPaginator->options(array('url' => '/administration/group_administrators/index'));	

function customizeCellData($row,$helpers) {
	$row['User']['full_name'] = $row['User']['first_name'] . ' ' . $row['User']['last_name'];
	
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/administration/administrators/edit/' . $row['User']['id'];
}

echo $this->element('recordset2',array(
	'records' => $this->data,
	'fields' => array('User.username','User.full_name'),
	'headers' => array(
		$myPaginator->sort(__('Username',true),'username'),
		$myPaginator->sort(__('Name',true),'last_name')	
	),
	'cell_customizer' => 'customizeCellData',
	'row_url_customizer' => 'customizeRowURL'
));