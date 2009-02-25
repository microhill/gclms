<?
$javascript->link(array(
	'vendors/prototype1.6.0.3',
	'vendors/prototype_extensions1.0',
	'gclms',
	'course'
), false);

$menu->addMenu(array(
	'name' => 'available_classes',
	'label' => __('Available Classes',true),
	'section' => 'secondary_column',
	'class' => 'gclms-unbulleted-list gclms-available-classes'
));

foreach($available_classes as $class) {	
	$content = '<strong>' . $class['VirtualClass']['title'] . '</strong><br/>';
	if($class['VirtualClass']['start'] && $class['VirtualClass']['end'])
		$content .= $myTime->niceShortDate($class['VirtualClass']['start']) . ' - ' . $myTime->niceShortDate($class['VirtualClass']['end']);
	
	$menu->addMenuItem('available_classes',array(
		'content' => $content,
		'url' => Course::get('web_path') . '/' . $class['VirtualClass']['id']
	));
}

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