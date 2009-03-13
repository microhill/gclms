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
		<h1><?= sprintf(__('Welcome, %s',true),$user['User']['first_name']) ?></h1>
		<h2><? __('Your progress (mockup)') ?></h2>
		<?
		$title = urlencode('Romans and Galatians (60%)');
		?>
		<img src="http://chart.apis.google.com/chart?chs=300x125&chd=t:60,40&cht=p3&chf=bg,s,f6f6f6&chtt=<?= $title ?>" />
		
		<?
		$title = urlencode('Life of Christ (80%)');
		?>
	<img src="http://chart.apis.google.com/chart?chs=300x125&chd=t:80,20&cht=p3&chf=bg,s,f6f6f6&chtt=<?= $title ?>" />
		
		<h2><? __('Notebook (finished but broken)') ?></h2>
		<?
		pr($notebook_entries);
		?>
	</div>
</div>

<?= $this->element('right_column'); ?>
