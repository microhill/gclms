<head>
	<title><?= $title_for_layout ?></title>
	<!--  <? if(!empty($title_for_layout)) echo '&raquo; ' . Configure::read('Site.name'); ?> -->

	<?= $html->charset('UTF-8'); ?>
    <?= $html->css(am($css_for_layout,__('TEXT DIRECTION',true))) ?>
	<?
	$html->css('tags', null, null, false);
	$html->css('main', null, null, false);
	$html->css('layout', null, null, false);
	$html->css('recordset', null, null, false);
	$html->css('tooltip', null, null, false);
	$html->css('menu', null, null, false);
	$html->css('mp3_player', null, null, false);
	$html->css('lesson_navigation', null, null, false);
	$html->css('lessons', null, null, false);
	$html->css('textbooks', null, null, false);
	$html->css('chapters', null, null, false);
	$html->css('files', null, null, false);
	$html->css('edit_page', null, null, false);
	$html->css('chat', null, null, false);
	$html->css('panel', null, null, false);
	$html->css('classroom', null, null, false);
	$html->css('plugins', null, null, false);
	$html->css('export', null, null, false);

	echo $asset->css_for_layout();
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->

	<?
	if(!empty($group['web_path'])) {
		$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		//echo '<link rel="stylesheet" type="text/css" href="/' . $group['web_path'] . '/files/css' . $cssLastUpdated . '" />';
	}
	?>
</head>