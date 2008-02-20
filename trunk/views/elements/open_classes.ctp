<? if(!empty($facilitated_classes)): ?>
	<ul class="gclms-unbulleted-list detailedList">
	<? foreach($facilitated_classes as $facilitated_class): ?>
		<?
		$classUri = $groupAndCoursePath . '/courses/enroll/' . $facilitated_class['FacilitatedClass']['id']; // . $course['web_path'] . '/lesson:' . $lesson['Lesson']['order'] . '/item:1';
		?>
		<li><a href="<?= $classUri ?>"><span class="classAlias"><?= $facilitated_class['FacilitatedClass']['alias'] ?></span><br/>
		Enrollment deadline: <?= $myTime->niceShortDate($facilitated_class['FacilitatedClass']['enrollment_deadline']) ?><br/>
		Begins: <?= $myTime->niceShortDate($facilitated_class['FacilitatedClass']['beginning']) ?><br/>
		Ends: <?= $myTime->niceShortDate($facilitated_class['FacilitatedClass']['end']) ?>
		</a></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>