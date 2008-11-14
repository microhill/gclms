<?
$myPaginator->options(array('url' => '/administration/users/index'));	

function customizeRowURL($row,$defaultUrl) {
	return '/administration/users/edit/' . $row['User']['id'];
}

echo $this->element('recordset2',array(
	'records' => $this->data,
	'fields' => array('User.first_name','User.last_name','User.email'),
	'headers' => array(
		$myPaginator->sort(__('First name',true),'first_name'),
		$myPaginator->sort(__('Last name',true),'last_name'),
		$myPaginator->sort(__('E-mail',true),'email')
	),
	'row_url_customizer' => 'customizeRowURL'
));