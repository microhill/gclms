<?
$html->css('chapters', null, null, false);

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'vendors/uuid',
	'vendors/scriptaculous1.8.1/scriptaculous',
	'vendors/scriptaculous1.8.1/dragdrop',
	'edit_chapters'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<div id="gclms-spinner"><img src="/img/permanent/spinner2007-09-14.gif" alt="Spinner" /></div>
		<?= $this->element('notifications'); ?>
		<div class="gclms-step-back"><a href="<?= $groupAndCoursePath ?>/books"><? __('Back to Books') ?></a></div>
		<h1><?= $book['Book']['title'] ?> </h1>
		<div id="gclms-menubar">
			<? echo $this->element('menubar',array('buttons' => array(
				array(
					'id' => 'addChapter',
					'class' => 'gclms-add',
					'label' => '<u>A</u>dd Chapter',
					'accesskey' => 'a',
					'strings' => array(
						'gclms:prompt-text' => 'Enter the name of the chapter:'
					)
				),
				array(
					'id' => 'renameChapter',
					'class' => 'gclms-rename',
					'label' => '<u>R</u>ename Chapter',
					'accesskey' => 'r',
					'strings' => array(
						'gclms:prompt-text' => 'Enter the new name of the chapter:'
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'deleteChapter',
					'class' => 'gclms-delete',
					'label' => '<u>D</u>elete Chapter',
					'accesskey' => 'd',
					'strings' => array(
						'gclms:confirm-text' => 'Are you sure you want to delete this chapter?'
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'editChapter',
					'class' => 'gclms-edit',
					'label' => '<u>E</u>dit Chapter',
					'accesskey' => 'e',
					'strings' => array(
						'gclms:confirm-text' => 'Are you sure you want to delete this chapter?'
					),
					'disabled' => 'disabled'
				)
			)));
			?>
		</div>
		<?
		echo '<ul id="chapters" class="chapters" book:id="' . $book['Book']['id'] . '">';
		foreach($chapters as $chapter) {
			echo '<li id="chapter_' . $chapter['Chapter']['id'] . '" chapter:id="' . $chapter['Chapter']['id'] . '"><a href="#">' . $chapter['Chapter']['title'] . '</a></li>';
		}
		echo '</ul>';
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>