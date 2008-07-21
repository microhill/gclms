<?
$myPaginator->options();	

$headers = array(
	$myPaginator->sort(__('Alias',true),'alias'),
	__('Course', true),
	__('Begins - Ends', true)
);

$fields = array(
	'VirtualClass.alias',
	'Course.title',
	'VirtualClass.beginning'
);

function customizeCellData($row,$helpers) {
	if(!empty($row['VirtualClass']['beginning']) && !empty($row['VirtualClass']['end'])) {
		$row['VirtualClass']['beginning'] = $helpers['myTime']->niceShortDate($row['VirtualClass']['beginning']) . ' - ' . $helpers['myTime']->niceShortDate($row['VirtualClass']['end']);
	}
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/' . $defaultUrl['group']['web_path'] . '/virtual_classes/edit/' . $defaultUrl['id'];
}

echo $this->element('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => __('Classes', true),
	'addButtonUrl' => '/' . $group['web_path'] . '/classes/add',
	'data' => $this->data
));