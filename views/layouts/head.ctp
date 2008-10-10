<head>
	<title><?= $title_for_layout ?></title>
	<!--  <? if(!empty($title_for_layout)) echo '&raquo; ' . Configure::read('App.name'); ?> -->

	<?= $html->charset('UTF-8'); ?>
	<?
	$html->css('main', null, null, false);
	$html->css($text_direction, null, null, false);
	$html->css('languages/' . Configure::read('Config.language'), null, null, false);
	
	echo $asset->css_for_layout(@$offline);
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->

	<?
	/*
	if(!empty(Group::get('web_path'))) {
		$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		echo '<link rel="stylesheet" type="text/css" href="/' . Group::get('web_path') . '/files/css' . $cssLastUpdated . '" />';
	}
	*/
	
	echo $html->meta(array('type' => 'application/rss+xml', 'rel' => 'alternate', 'title' => __('Recently Published Courses',true), 'link' => '/courses/recent.rss'));
	?>
	<!-- link href="" type="application/rss+xml" rel="alternate" title="rss"/ -->
</head>