<?
if(!empty($facilitated_class))
	$sectionUriComponent = '/section:' . $facilitated_class['id'];
else
	$sectionUriComponent = '';

if(empty($uncategorized))
	echo '<ul>';
	
foreach($pages as $page) {
	echo '<li><img src="/img/page-16.png" class="gclms-page-icon" />';

	$url = $groupAndCoursePath;
	$url .= '/classroom/page'; //' . $lesson['id'];

	$page = $page['Page'];
	$url .= $sectionUriComponent . '/' . $page['id'];

	echo sprintf('<a target="courseContent" href="%s" class="page %s">%s</a>',$url,$firstPage,$page['title']);
	$firstPage = '';
	echo '</li>';
}

if(empty($uncategorized))
	echo '</ul>';