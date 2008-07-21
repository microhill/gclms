<? if(!empty($virtual_classes)): ?>
	<ul class="gclms-unbulleted-list detailedList">
	<? foreach($virtual_classes as $virtual_class): ?>
		<?
		$classUri = $groupAndCoursePath . '/courses/enroll/' . $virtual_class['FacilitatedClass']['id']; // . $course['web_path'] . '/lesson:' . $lesson['Lesson']['order'] . '/item:1';
		?>
		<li><a href="<?= $classUri ?>"><span class="gclms-class-alias"><?= $virtual_class['FacilitatedClass']['alias'] ?></span><br/>
		Enrollment deadline: <?= $myTime->niceShortDate($virtual_class['FacilitatedClass']['enrollment_deadline']) ?><br/>
		Begins: <?= $myTime->niceShortDate($virtual_class['FacilitatedClass']['beginning']) ?><br/>
		Ends: <?= $myTime->niceShortDate($virtual_class['FacilitatedClass']['end']) ?>
		</a></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>