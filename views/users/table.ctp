<?
$myPaginator->options(array('url' => '/administration/users/index'));	

function customizeRowURL($row,$defaultUrl) {
	return '/administration/users/edit/' . $row['User']['id'];
}

echo $this->element('recordset2',array(
	'records' => $this->data,
	'fields' => array('User.username','User.email'),
	'headers' => array(
		$myPaginator->sort(__('Username',true),'username'),
		$myPaginator->sort(__('E-mail',true),'email')
	),
	'row_url_customizer' => 'customizeRowURL'
));