<?
$html->css('chapters', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'vendors/prototype_extensions1.0',
	'gclms',
	'vendors/uuid1.0',
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
					'label' => __('Add Chapter',true),
					'accesskey' => 'a',
					'strings' => array(
						'gclms:prompt-text' => __('Enter the name of the chapter:',true)
					)
				),
				array(
					'id' => 'renameChapter',
					'class' => 'gclms-rename',
					'label' => __('Rename Chapter',true),
					'accesskey' => 'r',
					'strings' => array(
						'gclms:prompt-text' => __('Enter the new name of the chapter:',true)
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'deleteChapter',
					'class' => 'gclms-delete',
					'label' => __('Delete Chapter',true),
					'accesskey' => 'd',
					'strings' => array(
						'gclms:confirm-text' => __('Are you sure you want to delete this chapter?',true)
					),
					'disabled' => 'disabled'
				),
				array(
					'id' => 'editChapter',
					'class' => 'gclms-edit',
					'label' => __('Edit Chapter',true),
					'accesskey' => 'e',
					'strings' => array(
						'gclms:confirm-text' => __('Are you sure you want to delete this chapter?',true)
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