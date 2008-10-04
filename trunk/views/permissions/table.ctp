<?
$myPaginator->options(array('url' => '/' . $group['web_path'] . '/permissions/index'));	

$headers = array(
	$myPaginator->sort(__('First Name',true),'first_name'),
	$myPaginator->sort(__('Last Name',true),'last_name')
);
$fields = array('User.first_name','User.last_name');

function customizeRowURL($row,$defaultUrl) {
	return '/permissions/edit/' . $defaultUrl['id'];
}

function customizeCellData($row,$helpers) {
	return $row;
}

echo $this->element('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => __('Permissions',true),
	'data' => $this->data,
	'addButtonUrl' => $groupAndCoursePath . '/permissions/add'
));