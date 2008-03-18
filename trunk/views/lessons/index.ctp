<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_lessons'
), false);

echo $this->renderElement('left_column');
?>
		
<div class="gclms-center-column">
	<div class="gclms-content">	
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<h1><? __('Units and Lessons') ?> </h1>
		<p class="buttons">
			<button id="addUnit" class="add" gclms:prompt-text="<? __('Enter the name of the unit:') ?>"><? __('Add Unit') ?></button>
			<button id="addLesson" class="add" gclms:prompt-text="<? __('Enter the name of the lesson:') ?>"><? __('Add Lesson') ?></button>
			<button id="renameUnit" class="rename" gclms:prompt-text="<? __('Enter the new name of the unit:') ?>"><? __('Rename') ?></button>
			<button id="deleteUnit" class="delete" gclms:notempty-text="<? __('This unit is not empty.') ?>" gclms:confirm-text="<? __('Are you sure you want to delete this unit?') ?>"><? __('Delete') ?></button>
			<button id="renameLesson" class="rename" gclms:prompt-text="<? __('Enter the new title of the lesson:') ?>"><? __('Rename') ?></button>
			<button id="deleteLesson" class="delete" gclms:confirm-text="<? __('Are you sure you want to delete this lesson?') ?>"><? __('Delete') ?></button>
			<button id="showLesson" class="edit"><? __('Show in Classroom') ?></button>
			<button id="editLesson" class="edit"><? __('Edit') ?></button>
		</p>
		<div id="units">
			<div id="categorizedLessons">
		<?			
		$categorizedLessons = array();
		$unCategorizedLessons = array();
		
		foreach($lessons as $lesson) {
			if(empty($lesson['Lesson']['unit_id'])) {
				$unCategorizedLessons[$lesson['Lesson']['order']] = $lesson['Lesson'];
				continue;
			}
			$unit_id = $lesson['Lesson']['unit_id'];
			if(empty($categorizedLessons[$unit_id]))
				$categorizedLessons[$unit_id] = array();
			$categorizedLessons[$unit_id][$lesson['Lesson']['order']] = $lesson['Lesson'];
		}
		foreach($units as $unit): ?>
			<div id="<?= 'unit_' . $unit['Unit']['id'] ?>" unit:id="<?= $unit['Unit']['id'] ?>" class="unit">
				<h2 class="unitHandle" id="unitHandle_<?= $unit['Unit']['id'] ?>">
					<a href="#"><?= $unit['Unit']['title'] ?></a>
				</h2>
				<ul id="unitLessons<?= 'unit_' . $unit['Unit']['id'] ?>" class="lessons">
				<? 
				if(@$categorizedLessons[$unit['Unit']['id']]) {
					foreach($categorizedLessons[$unit['Unit']['id']] as $lesson)
						echo '<li id="lesson_' . $lesson['id'] . '" lesson:id="' . $lesson['id'] . '"><a href="#">' . $lesson['title'] . '</a></li>';
				}
					?>
				</ul>
			</div>
		<?
		endforeach;
		echo '</div>';
		
		echo '<div id="unsortedLessonsContainer" unit:id="0" class="unit">';
		echo '<h2 id="unsortedLessonsHeader" class="' . (empty($units) ? 'hidden' : '') . '"><a href="#">' . __('Uncategorized Lessons',true) . '</a></h2>';
		echo '<ul id="unsortedLessonsList" class="lessons">';
		foreach($unCategorizedLessons as $lesson) {
			echo '<li id="lesson_' . $lesson['id'] . '" lesson:id="' . $lesson['id'] . '"><a href="#">' . $lesson['title'] . '</a></li>';
		}
		echo '</ul>';
		echo '</div>';
		echo '</div>';
		?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>