<head>
	<title><?= $title_for_layout ?></title>

	<?= $html->charset('UTF-8'); ?>
	<?
	echo $html->css('/css/main');
	if(!empty($text_direction))
		$html->css('/css/' . $text_direction . '.css', null, null, false);
	else
		echo $html->css('/css/ltr');
	$html->css('languages/' . Configure::read('Config.language'), null, null, false);

	if(isset($asset)) {
		echo $asset->css_for_layout(@$offline);		
	}

	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->
</head>