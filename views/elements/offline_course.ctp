<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<?= $text_direction ?>">
<head>
	<title><?= $title_for_layout ?></title>

	<?= $html->charset('UTF-8'); ?>
	<link rel="stylesheet" type="text/css" href="../../css/main.css" />
	<link rel="stylesheet" type="text/css" href="../../css/<?= $text_direction ?>.css" />
	<?
	echo $asset->css_for_layout($offline);
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->
</head>

<body
		gclms-group="<?= @$group['web_path'] ?>"
		gclms-course="<?= @$course['web_path'] ?>"
		gclms-controller="<?= $this->name ?>"
		gclms-action="<?= $this->action ?>"
		gclms-direction="<?= $text_direction ?>"
		gclms-language="<?= Configure::read('Config.language') ?>">
	<div style="min-height: 100%;">
		<?= $this->element('banner',array('here'=>$groupAndCoursePath . '/')) ?>
		<?= $this->element('breadcrumbs',array('here'=>$groupAndCoursePath . '/')); ?>
		
		<div id="gclms-page">
			<?
			$javascript->link(array(
				'vendors/prototype1.6.0.2',
				'prototype_extensions1.0',
				'gclms',
				'course'
			));
			
			echo $this->element('no_column_background'); ?>
			<div class="gclms-center-column">
				<div class="gclms-content">
					<?= $this->element('notifications'); ?>
					<h1><?= $course['title'] ?></h1>
					<?
					
					if(!empty($news_items)){
						echo $this->element('news_items');
					}
			
					if(!empty($nodes))
						echo $this->element('nodes_tree',array(
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

