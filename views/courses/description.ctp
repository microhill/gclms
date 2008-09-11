<?
$javascript->link(array(
	'vendors/prototype1.6.0.2',
	'prototype_extensions1.0',
	'gclms',
	'course'
), false);

echo $this->element('left_column'); ?>

<div class="gclms-center-column">
	<div class="gclms-content">
		<?= $this->element('notifications'); ?>
		<h1><?= $course['title'] ?></h1>

		<? if($course['language'] != Configure::read('Config.language')): ?>
			<!-- p><?= implode(order(array(__('Language:',true), ' ', $languages[$course['language']]))) ?></p -->
		<? endif;
		
		if(empty($virtual_class)) {
			App::import('Vendor','scripturizer'.DS.'scripturizer');
			$course['description'] = scripturize($course['description'],'NET');
			echo $course['description'];
		} else if(!empty($news_items)){
			echo $this->element('news_items');
		}

		if(!empty($nodes))
			echo $this->element('nodes_tree',array(
				'nodes' => $nodes,
				'here' => $this->here,
				'sibling_links' => false
			));
		
		if(!empty($course['redistribution_allowed'])): ?>
			<p>
				<a rel="license" href="<?= $license->getUrl($course['redistribution_allowed'],$course['commercial_use_allowed'],$course['derivative_works_allowed']) ?>"><img src="/img/somerights_en.png" width="88" height="31" /></a>
			</p>
		<? endif; ?>
	</div>
</div>

<?= $this->element('right_column'); ?>