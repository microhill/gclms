<div id="table">
	<?
	$headers = array(
		__('Username', true),
		__('Name', true)
	);
	$fields = array('User.username','User.full_name');
	
	function customizeCellData($row,$helpers) {
		$row['User']['full_name'] = $row['User']['first_name'] . ' ' . $row['User']['last_name'];
		return $row;
	}
	
	function customizeRowURL($row,$defaultUrl) {
		return $_SERVER["REQUEST_URI"] . '/edit/' . $row['User']['id'];
	}
	
	echo $this->renderElement('recordset',array(
		'headers' => $headers,
		'fields' => $fields,
		'heading' => __('Facilitators', true),
		'addButtonUrl' => '/' . $group['web_path'] . '/facilitators/add'
	));
	?>
</div>