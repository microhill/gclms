<?
$myPaginator->options(array('url' => '/administration/groups/index'));	

function customizeRowURL($row,$defaultUrl) {
	return '/administration/groups/edit/' . $row['Group']['id'];
}

echo $this->element('recordset2',array(
	'records' => $this->data,
	'fields' => array('Group.name','Group.web_path'),
	'headers' => array(
		$myPaginator->sort(__('Name',true),'name'),
		$myPaginator->sort(__('Web path',true),'web_path')
	),
	'row_url_customizer' => 'customizeRowURL'
));