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
		<h1><?= Group::get('name') ?></h1>
		<?
		$web_address = str_replace(array('http://www.','http://'), array('',''), Group::get('external_web_address'));
		if(substr($web_address, -1) == '/')
			$web_address = substr($web_address, 0, -1);
		
		if(Group::get('external_web_address')): ?>
		<p><a href="<?= Group::get('external_web_address') ?>" class="gclms-group-web-address"><?= $web_address ?></a></p>
		<? endif; ?>
		<?= Group::get('description') ?> 
	</div>
</div>

<?= $this->element('right_column') ?>