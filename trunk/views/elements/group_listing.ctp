<?
if(!empty($my_groups)) {
	$menu->addMenu(array(
		'name' => 'my_groups',
		'title' => __('My Groups',true),
		'section' => 'secondary_column',
		'class' => 'gclms-unbulleted-list'
	));
	
	foreach($my_groups as $groupWebPath => $groupName) {
		$menu->addMenuItem('my_groups',array(
			'content' => $groupName,
			'url' => '/' . $groupWebPath
		));
	}
}