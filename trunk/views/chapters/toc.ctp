<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_chapters'
), false);


echo $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif"/></div>
		<?= $this->renderElement('notifications'); ?>
		<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/books"><? __('Back to Books') ?></a></div>
		<h1><?= $book['Book']['title'] ?> </h1>
		<p class="buttons">
			<button id="addChapter" class="add" prompt:text="<? __('Enter the name of the chapter:') ?>"><? __('Add Chapter') ?></button>
			<button id="renameChapter" class="rename" prompt:text="<? __('Enter the new name of the chapter:') ?>"><? __('Rename') ?></button>
			<button id="deleteChapter" class="delete" confirm:text="<? __('Are you sure you want to delete this chapter?') ?>"><? __('Delete') ?></button>
			<button id="editChapter" class="edit"><? __('Edit') ?></button>
		</p>
		<?
		echo '<ul id="chapters" class="chapters" book:id="' . $book['Book']['id'] . '">';
		foreach($chapters as $chapter) {
			echo '<li id="chapter_' . $chapter['Chapter']['id'] . '" chapter:id="' . $chapter['Chapter']['id'] . '"><a href="#">' . $chapter['Chapter']['title'] . '</a></li>';
		}
		echo '</ul>';
		?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>