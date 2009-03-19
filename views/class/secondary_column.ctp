<?
/*
echo $this->element('block',array(
	'title' => $class['title'],
	'content' => $this->element('../class/info')
));

echo $this->element('block',array(
	'title' => 'Upcoming Assignments',
	'content' => '<div class="gclms-wrapper">...</div>'
));

echo $this->element('block',array(
	'title' => 'Recent Grades',
	'content' => '<div class="gclms-wrapper">...</div>'
));
*/

$menu->addMenu(array(
	'name' => 'upcoming_assignments',
	'title' => __('Due Soon',true),
	'section' => 'secondary_column',
	'class' => 'gclms-unbulleted-list'
));

foreach($upcoming_assignments as $assignment) {
	$menu->addMenuItem('upcoming_assignments',array(
		'content' => $assignment['Assignment']['title'] . ' ' . '(Friday, March 6th)',
		'url' => $groupAndCoursePath . '/assignments/view/' . $assignment['Assignment']['id']
	));	
}

if(!ClassEnrollee::get('id')) {
	$block->add(array(
		'name' => 'profile',
		'title' => __('Class Information',true),
		'content' => $this->element('../class/summary'),
		'section' => 'secondary_column'
	));
}
