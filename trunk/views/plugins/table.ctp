<?
$myPaginator->options(array('limit' => '1000'));

$headers = array(
	__('Name',true),
	__('Version',true),
	__('Activated',true)
);
$fields = array('Plugin.name','Plugin.version','Plugin.activated');

function customizeCellData($row,$helpers) {
	$row['Plugin']['name'] = text_direction($row['Plugin']['name'],' ','(',$row['Plugin']['type'],')');
	$row['Plugin']['version'] = '<div class="gclms-plugin-version">' . $row['Plugin']['version'] . '</div>';
	if(!empty($row['Plugin']['activated']))
		$row['Plugin']['activated'] = '<div class="gclms-plugin-activated"><img src="/img/icons/oxygen/16x16/actions/dialog-ok.png" /></div>';
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/administration/plugins/toggle/' . $row['Plugin']['folder'];
}

echo $this->renderElement('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => 'Plugins',
	'data' => $this->data,
	'showDefaultAddButton' => false
));