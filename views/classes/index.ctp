<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column');
?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Classes') ?></h1>
		<button href="classes/add">Add</button>
		<?
		foreach($this->data as $course_id => $classes) {
			?><p><strong><?= $courses[$course_id]['title'] ?></strong></p><ul><?
			foreach($classes as $class) {
				$groupAndCoursePath = Group::get('web_path') . '/' . $courses[$course_id]['web_path'];
				
				?>
				<li>
					<a href="/<?= $groupAndCoursePath ?>/<?= $class['id'] ?>"><?= $class['title'] ?></a> (<a href="<?= Group::get('web_path') ?>/classes/edit/<?= $class['id'] ?>">edit</a>)<br/>
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