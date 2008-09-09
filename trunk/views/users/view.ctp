<?
$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($user['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" />
		<?
		pr($notebook_entries);
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>
