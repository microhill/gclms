<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('left_column');
?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Classes') ?></h1>
		<?
		
		echo $this->element('menubar',array('buttons' => array(
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
				$groupAndCoursePath = $groupWebPath . '/' . $courses[$course_id]['web_path'];
				
				?>
				<li>
					<a href="<?= $groupAndCoursePath ?>/<?= $class['id'] ?>"><?= $class['alias'] ?></a> (<a href="<?= $groupWebPath ?>/classes/edit/<?= $class['id'] ?>">edit</a>)<br/>
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
echo $this->element('right_column');