<head>
	<title><?= $title_for_layout ?></title>
	<!--  <? if(!empty($title_for_layout)) echo '&raquo; ' . Configure::read('Site.name'); ?> -->

	<?= $html->charset('UTF-8'); ?>
	<?
	$html->css('main', null, null, false);
	$html->css(__('TEXT DIRECTION',true), null, null, false);
	
	echo $asset->css_for_layout();
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->

	<?
	/*
	if(!empty($group['web_path'])) {
		$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		echo '<link rel="stylesheet" type="text/css" href="/' . $group['web_path'] . '/files/css' . $cssLastUpdated . '" />';
	}
	*/
	?>
</head>