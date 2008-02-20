<? if(!empty($lessons)): ?>
	<div class="lessons gclms-wrapper">
		<?
		foreach($lessons as $lesson) {
			$tmpLessons[$lesson['Lesson']['unit_id']][$lesson['Lesson']['order']] = $lesson['Lesson'];
		}

		/*
		if(count($units) > 1): ?>
			<h2><? __('Units and Lessons') ?></h2>
		<? else: ?>
			<h2><? __('Lessons') ?></h2>
		<? endif;
		*/
				
		$units[] = array('Unit' => array('id' => 0));
		$lessonNumber = 1;
		foreach($units as $unit) {
			if(empty($tmpLessons[$unit['Unit']['id']]))
				continue;
	
			if(!empty($unit['Unit']['title']))
				echo '<h3>' . $unit['Unit']['title'] . '</h3>';
			else if(count($units) > 1)
				echo '<h3>' . __('Uncategorized Lessons',true) . '</h3>';
	
			echo '<ul class="Classes">';
			foreach($tmpLessons[$unit['Unit']['id']] as $lesson) {
				$url = $groupAndCoursePath . '/classroom/lesson/' . $lesson['id'];
				//if(isset($facilitated_class))
					//$url .= '/' . $facilitated_class['id'];
				echo '<li><a href="' . $url . '">';
				//echo text_direction($lessonNumber, '.', ' ', $lesson['title']);
				echo $lesson['title'];
				echo '</a></li>';
				$lessonNumber++;
			}
			echo '</ul>';
		}
		?>
	</div>
<? endif; ?>