<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

$this->element('user_menu');
$block->add(array(
	'name' => 'profile',
	'title' => $user['User']['username'],
	'content' => 'test'
));

/*
return $view->element('panel',array(
	'title' => $this->menus[$name]['label'],
	'content' => $html
));
*/

echo $this->element('left_column',array(
	//'primary_column' => $primary_column,
	//'secondary_column' => @$secondary_column
)); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= md5($user['email']) ?>&default=<?= urlencode(@$default) ?>&size=96" />
		<?
		pr($notebook_entries);
		?>
	</div>
</div>

<?= $this->element('right_column',array(
	//'primary_column' => $primary_column,
	//'secondary_column' => @$secondary_column
)); ?>
