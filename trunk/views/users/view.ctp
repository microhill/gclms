<?
$html->css('profile', null, null, false);

$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms'
), false);

$this->element('user_menu');
$block->add(array(
	'name' => 'profile',
	'title' => __('Profile',true),
	'content' => $this->element('../users/profile_block')
));

//---/

echo $this->element('block',array(
	'title' => 'My Classes',
	'content' => $this->element('class_listing')
));

echo $this->element('block',array(
	'title' => 'My Groups',
	'content' => $this->element('group_listing')
));	

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<?
		pr($notebook_entries);
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>
