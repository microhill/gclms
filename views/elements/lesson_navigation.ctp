<div class="gclms-lesson-navigation">
<?
if(!empty($facilitated_class))
	$sectionUriComponent = '/section:' . $facilitated_class['id'];
else
	$sectionUriComponent = '';

foreach($lessons as $lesson) {
	$tmpLessons[$lesson['Lesson']['unit_id']][$lesson['Lesson']['order']] = $lesson['Lesson'];
}

$units[] = array('Unit' => array('id' => 0)); //For uncategorized lessons
$lessonNumber = 1;
$firstPage = 'selected';

foreach($units as $unit) {
	if(empty($tmpLessons[$unit['Unit']['id']]))
		continue;

	if(!empty($unit['Unit']['title']))
		echo '<h2>' . $unit['Unit']['title'] . '</h2>';
	else if(count($units) > 1)
		echo '<h2>' . __('Uncategorized Lessons',true) . '</h2>';
	
	echo '<ul>';
	foreach($tmpLessons[$unit['Unit']['id']] as $lesson) {
		$url = $groupAndCoursePath;
		
		echo '<li><img src="/img/blank-1.png" class="';
		if($lesson['id'] == $current_lesson['id'])
			echo 'gclms-expanded';
		else
			echo 'gclms-collapsed';
		echo '" /><img src="/img/folder-22.png" class="gclms-folder-icon" /><a href="' . $groupAndCoursePath . '/classroom/lesson/' . $lesson['id'] . '" class="lesson">';
		echo $lessonNumber, '.', ' ', $lesson['title'];
		echo '</a>';

		if($lesson['id'] == $current_lesson['id']) {
			echo $this->element('lesson_navigation_lesson',array(
				'topics' => $topics,
				'lesson' => $lesson
			));
		}
		$lessonNumber++;
		
		echo '</li>';
	}
	echo '</ul>';
}
?>
</div>