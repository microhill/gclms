<div id="table">
	<?
	$myPaginator->options(array('url' => '/administration/group_administrators/index'));	
	
	$headers = array(
		$myPaginator->sort(__('Group',true),'name'),
		$myPaginator->sort(__('Username',true),'username'),
		$myPaginator->sort(__('Name',true),'first_name')	
	);
	$fields = array('Group.name','User.username','User.full_name');
	
	function customizeCellData($row,$helpers) {
		$row['User']['full_name'] = $row['User']['first_name'] . ' ' . $row['User']['last_name'];
		
		return $row;
	}
	
	function customizeRowURL($row,$defaultUrl) {
		return '/administration/group_administrators/edit/' . $row['GroupAdministrator']['id'] . '/';
	}
	
	echo $this->renderElement('recordset',array(
		'headers' => $headers,
		'fields' => $fields,
		'heading' => 'Group Administrators',
		'data' => $data
	));
	?>
</div>