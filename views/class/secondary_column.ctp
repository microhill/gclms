<?
echo $this->element('panel',array(
	'title' => $class['username'],
	'content' => $this->element('../class/info')
));

echo $this->element('panel',array(
	'title' => 'Upcoming Assignments',
	'content' => '<div class="gclms-wrapper">...</div>'
));

echo $this->element('panel',array(
	'title' => 'Recent Grades',
	'content' => '<div class="gclms-wrapper">...</div>'
));