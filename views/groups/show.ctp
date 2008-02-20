<?= $this->renderElement('left_column'); ?>

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
		<?= !empty($group['description']) ? $text->flay($group['description'], true) : ''; ?> 
	</div>
</div>

<?= $this->renderElement('right_column'); ?>