<?

$javascript->link(array(
	'vendors/prototype',
	'prototype_extensions',
	'gclms',
	'course'
), false);

echo $this->renderElement('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->renderElement('notifications'); ?>
		<h1><?= $course['title'] ?></h1>
		<? if($course['language'] != Configure::read('Config.language')): ?>
			<p><?= implode(order(array(__('Language:',true), ' ', $languages[$course['language']]))) ?></p>
		<? endif; ?>

		<p>
			<?
			if(empty($facilitated_class)) {
				App::import('Vendor','scripturizer'.DS.'scripturizer');
				$course['description'] = scripturize($course['description'],'NET');
				echo $course['description'];
			} else if(!empty($news_items)){
				echo $this->renderElement('news_items');
			}
			?>
		</p>

		<?
		if(!empty($nodes))
			echo $this->renderElement('nodes_tree',array(
				'nodes' => $nodes
			));
		
		if(!empty($course['redistribution_allowed'])): ?>
			<p>
				<a href="<?= $license->getUrl($course['redistribution_allowed'],$course['commercial_use_allowed'],$course['derivative_works_allowed']) ?>"><img src="/img/somerights_en.png" width="88" height="31" /></a>
			</p>
		<? endif; ?>
	</div>
</div>

<?= $this->renderElement('right_column'); ?>