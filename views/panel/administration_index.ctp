<?
echo $this->renderElement('left_column'); ?>
		
<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><? __('Site Administration') ?></h1>
	
		<p><?= sprintf('This site has a total of %s groups, %s courses, and %s users.',$group_count,$course_count,$user_count) ?></p>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>