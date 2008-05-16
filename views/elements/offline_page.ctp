<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? __('TEXT DIRECTION'); ?>">
<head>
	<title><?= $title_for_layout ?></title>

	<?= $html->charset('UTF-8'); ?>
	<link rel="stylesheet" type="text/css" href="../../../../css/main.css" />
	<link rel="stylesheet" type="text/css" href="../../../../css/page.css" />
	<link rel="stylesheet" type="text/css" href="../../../../css/<?= __('TEXT DIRECTION') ?>.css" />
	<?
	echo $asset->css_for_layout($offline);
	?>
	<!--[if lte IE 6]><?= $html->css('../../../../css/ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('../../../../css/ie7_or_less') ?><![endif]-->
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
		
		<div class="gclms-content">
			<div class="gclms-page gclms-noframes">
				<?
				$javascript->link(array(
					'vendors/prototype',
					'prototype_extensions',
					'gclms',
					'vendors/scriptaculous1.8.1/scriptaculous',
					'vendors/scriptaculous1.8.1/dragdrop',
					'page'
				));
				
				echo $this->renderElement('no_column_background'); ?>
				<h1><?= $node['title'] ?></h1>
				<?
				$classUri = null;
			
				$nodeItems = array();
				foreach($node['Textarea'] as $textarea) {
					$nodeItems[$textarea['order']] = $textarea;
				}
			
				foreach($node['Question'] as $question) {
					$nodeItems[$question['order']] = $question;
				}
			
				ksort($nodeItems);
			
				foreach($nodeItems as $nodeItem) {
					if(isset($nodeItem['content'])) {
						//$nodeItem['content'] = $scripturizer->linkify($nodeItem['content']);
						//$nodeItem['content'] = $notebook->linkify($nodeItem['content'],$classUri);
						//$nodeItem['content'] = $glossary->linkify($nodeItem['content'],$groupAndCoursePath . '/glossary',$glossary_terms);
						echo $nodeItem['content'];
					} else
						echo $this->renderElement('page_question',array('question' => $nodeItem));
				}
				?>
				<div id="gclms-page-navigation">
					<? if(!empty($node['previous_page_id'])): ?>
						<a class="gclms-back" href="<?= $node['previous_page_id'] ?>.html">
							<img src="<?= relativize_url('/group/course/pages/view/page','/img/icons/oxygen_refit/32x32/actions/go-previous-blue.png') ?>" alt="<? __('Previous page') ?>" />
						</a>
					<? endif; ?>
				
					<? if(!empty($node['next_page_id'])): ?>
						<a class="gclms-next" href="<?= $node['next_page_id'] ?>.html">
							<img src="<?= relativize_url('/group/course/pages/view/page','/img/icons/oxygen_refit/32x32/actions/go-next-blue.png') ?>" alt="<? __('Next page') ?>" />
						</a>
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