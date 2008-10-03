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
		<?= $this->element('notifications'); ?>
		<h1><?
		__('Welcome');
		
		if($user['first_name'])
			echo ', ' . $user['first_name'];
		else
			echo ', ' . $user['username'];
		?></h1>

		<!-- img src="/files/front-page-looking-up.jpg" style="float: right;margin-left: 12px;margin-bottom: 8px;" / -->

		<p><? __('The Internet Biblical Seminary is') ?>:</p>
		<ol>
			<li><? __('A place for you to learn and grow as a Christian') ?></li>
			<li><? __('A hub for evangelical Christian e-learning') ?></li>
			<li><? __('An area for your church, school, or mission agency to host courses and train your own people') ?></li>
	   </ol>
		<p><? __('To read our statement of faith, view the classroom environment, or learn how your group can freely participate, please see our') ?> <a href=""><? __('introductory course') ?></a>.</p>

		<? if(!empty($new_courses)): ?>
			<div class="gclms-new-courses">
				<h2 style="border-bottom: 1px solid #ccc; margin-right: 12px; padding-bottom: 1px;"><? __('New Courses') ?></h2>
				<ul>
					<?
					foreach($new_courses as $new_course) {
						echo '<li><a href="/' . $new_course['Group']['web_path'] . '/' . $new_course['Course']['web_path'] . '">' . $new_course['Course']['title'] . '</a></li>';
					}
					?>
				</ul>
			</div>
		<? endif; ?>

		<? if(!empty($participating_group)): ?>
			<div class="gclms-participating-groups" style="float: left; width: 50%; margin-bottom: 12px;">
				<h2 style="border-bottom: 1px solid #ccc;"><? __('Participating Groups') ?></h2>
				<ul>
					<?
					foreach($participating_groups as $participating_group) {
						echo '<li><a href="/' .$participating_group['Group']['web_path'] . '">' . $participating_group['Group']['name'] . '</a></li>';
					}
					?>
				</ul>
			</div>
		<? endif; ?>
	</div>
</div>

<? echo $this->element('right_column'); ?>