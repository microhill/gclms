<?
if(!empty($enrollees)) {
	$menu->addMenu(array(
		'name' => 'class_listing',
		'title' => __('My Classes',true),
		'section' => 'secondary_column',
		'class' => 'gclms-unbulleted-list'
	));
	
	foreach($enrollees as $class) {
		$menu->addMenuItem('class_listing',array(
			'content' => $class['FacilitatedClass']['Course']['title'],
			'url' => '/' . $class['FacilitatedClass']['Course']['Group']['web_path'] . '/' . $class['FacilitatedClass']['Course']['web_path'] . '/' . $class['FacilitatedClass']['id']
		));
	}
}