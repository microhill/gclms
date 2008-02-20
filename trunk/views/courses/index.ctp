<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->renderElement('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->renderElement('notifications'); ?>	
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

<?= $this->renderElement('right_column'); ?>