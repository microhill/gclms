<?
$headers = array(
	$myPaginator->sort(__('Username',true),'username'),
	__('Course', true),
	__('Begins - Ends', true)
);
$fields = array(
	'FacilitatedClass.username',
	'Course.title',
	'FacilitatedClass.beginning'
);

function customizeCellData($row,$helpers) {
	if(!empty($row['FacilitatedClass']['beginning']) && !empty($row['FacilitatedClass']['end'])) {
		$row['FacilitatedClass']['beginning'] = $helpers['myTime']->niceShortDate($row['FacilitatedClass']['beginning']) . ' - ' . $helpers['myTime']->niceShortDate($row['FacilitatedClass']['end']);
	}
	return $row;
}

function customizeRowURL($row,$defaultUrl) {
	return '/' . $defaultUrl['group']['web_path'] . '/virtual_classes/edit/' . $defaultUrl['id'];
}

echo $this->element('recordset',array(
	'headers' => $headers,
	'fields' => $fields,
	'heading' => __('Facilitated Classes', true),
	'addButtonUrl' => '/' . Group::get('web_path') . '/virtual_classes/add'
));
?>