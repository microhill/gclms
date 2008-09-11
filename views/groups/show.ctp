<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms'
), false);

echo $this->element('left_column');
?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<h1><?= $group['name'] ?></h1>
		<?
		$web_address = str_replace(array('http://www.','http://'), array('',''), $group['external_web_address']);
		if(substr($web_address, -1) == '/')
			$web_address = substr($web_address, 0, -1);
		
		if(!empty($group['external_web_address'])): ?>
		<p><a href="<?= $group['external_web_address'] ?>" class="gclms-group-web-address"><?= $web_address ?></a></p>
		<? endif; ?>
		<?= $group['description'] ?> 
	</div>
</div>

<?= $this->element('right_column') ?>