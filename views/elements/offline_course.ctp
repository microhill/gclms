<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? __('TEXT DIRECTION'); ?>">
<head>
	<title><?= $title_for_layout ?></title>

	<?= $html->charset('UTF-8'); ?>
	<link rel="stylesheet" type="text/css" href="../../css/main.css" />
	<link rel="stylesheet" type="text/css" href="../../css/<?= __('TEXT DIRECTION') ?>.css" />
	<?
	echo $asset->css_for_layout($offline);
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->
</head>

<body
		gclms:group="<?= @$group['web_path'] ?>"
		gclms:course="<?= @$course['web_path'] ?>"
		gclms:controller="<?= $this->name ?>"
		gclms:action="<?= $this->action ?>"
		gclms:direction="<? __('TEXT DIRECTION'); ?>"
		gclms:language="<?= Configure::read('Config.language') ?>">
	<div style="min-height: 100%;">
		<?= $this->renderElement('banner',array('here'=>$groupAndCoursePath . '/')) ?>
		
		<?	
		echo $this->renderElement('breadcrumbs');
		?>
		
		<div id="gclms-page">
			<?
			$javascript->link(array(
				'vendors/prototype',
				'prototype_extensions',
				'gclms',
				'course'
			));
			
			echo $this->renderElement('no_column_background'); ?>
			<div class="gclms-center-column">
				<div class="gclms-content">
					<?= $this->renderElement('notifications'); ?>
					<h1><?= $course['title'] ?></h1>
					<?
					
					if(!empty($news_items)){
						echo $this->renderElement('news_items');
					}
			
					if(!empty($nodes))
						echo $this->renderElement('nodes_tree',array(
							'nodes' => $nodes,
							'here' => $groupAndCoursePath . '/index.html',
							'offline' => true
						));
					
					if(!empty($course['redistribution_allowed'])): ?>
						<p>
							<a rel="license" href="<?= $license->getUrl($course['redistribution_allowed'],$course['commercial_use_allowed'],$course['derivative_works_allowed']) ?>"><img src="/img/somerights_en.png" width="88" height="31" /></a>
						</p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="../../js/vendors/prototype.js"></script>
	<script type="text/javascript" src="../../js/prototype_extensions.js"></script>
	<script type="text/javascript" src="../../js/gclms.js"></script>
	<script type="text/javascript" src="../../js/course.js"></script>
</body>
</html>

