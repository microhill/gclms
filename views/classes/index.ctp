<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('left_column');
?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Classes') ?></h1>
		<?
		
		echo $this->renderElement('menubar',array('buttons' => array(
			array(
				'id' => 'gclms-add',
				'class' => 'gclms-add',
				'label' => 'Add',
				'strings' => array(
					'link:href' => $groupWebPath . '/classes/add'
				),
				'accesskey' => 'a'
		))));

		foreach($this->data as $course_id => $classes) {
			?><p><strong><?= $courses[$course_id]['title'] ?></strong></p><ul><?
			foreach($classes as $class) {
				?>
				<li>
					<a href="<?= $groupWebPath ?>/<?= $courses[$course_id]['web_path'] ?>/<?= $class['id'] ?>"><?= $class['alias'] ?></a><br/>
					<?
					if(!empty($class['start'])) {
						echo $myTime->niceShortDate($class['start']) . ' - ' . $myTime->niceShortDate($class['end']);
					}
					?>
				</li>
				<?
			}
			?></ul><?
		}
		?>
	</div>
</div>

<?
echo $this->renderElement('right_column');