<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? __('TEXT DIRECTION'); ?>">

<head>
	<title><?= $title_for_layout ?></title>

	<?= $html->charset('UTF-8'); ?>
	<?
	//echo $html->css('reset', null, null, false);
	echo $html->css('main', null, null, false);
	echo $html->css(__('TEXT DIRECTION',true), null, null, false); 
	echo $html->css('tinymce_popup', null, null, false);
	
	echo $asset->css_for_layout();
	?>
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->
</head>

<body>
	<div id="gclms-page">
		<?= $content_for_layout ?>
	</div>
	<?= $asset->js_for_layout(); ?>	
</body>
</html>