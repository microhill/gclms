<?
if(!empty($virtual_class))
	$sectionUriComponent = '/section:' . $virtual_class['id'];
else
	$sectionUriComponent = '';

$firstPage = 'selected';

echo '<ul>';

foreach($topics as $topic) {
	$topic = $topic['Page'];
	echo '<li><img src="/img/blank-1.png" /><img src="/img/page-16.png" class="gclms-page-icon" />';
	$url = $groupAndCoursePath;

	$url .= '/classroom/page/' . $topic['id'] . $sectionUriComponent;
		
	if(!isset($topic['title'])) {
		$topic['title'] = __('Uncategorized Lesson Items',true);
		$url = '#';
	}
	echo sprintf('<a target="courseContent" href="%s" class="topic %s">%s</a>',$url,$firstPage,$topic['title']);
	$firstPage = '';

	echo $this->element('lesson_navigation_pages',array(
		'pages' => $categorized_pages[$topic['id']],
		'lesson' => &$lesson,
		'firstPage' => $firstPage
	));

	echo '</li>';
}

if(empty($topics) && !empty($uncategorized_pages)) {
	//echo '<li><img src="/img/page-16.png" class="gclms-page-icon" />';
	//echo sprintf('<a target="courseContent" href="#">%s</a>',__('Uncategorized Lesson Items',true));

	echo $this->element('lesson_navigation_pages',array(
		'pages' => $uncategorized_pages,
		'lesson' => &$lesson,
		'firstPage' => $firstPage,
		'uncategorized' => true
	));
	//echo '</li>';
}

if(empty($topics) && empty($uncategorized_pages))
	echo '<li><em>' . __('There is no content in this lesson',true) . '</em></li>';
	
echo '</ul>';