<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>	
		<h1><? __('Course Catalogue') ?></h1>
		<?
//		pr($groups);
		
		foreach($groups as $group) {
			if(empty($group['Course']))
				continue;
			echo '<h3>' . $group['Group']['name'] . '</h3>';
			echo '<ul>';
			foreach($group['Course'] as $course) {
				echo '<li><a href="/' . $group['Group']['web_path'] . '/' . $course['web_path'] . '">' . $course['title'] . '</a></li>';
			}
			echo '</ul>';			
		}
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>