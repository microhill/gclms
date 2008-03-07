<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">

<head>
	<title><?= $title_for_layout ?> <? if(!empty($title_for_layout)) echo '&raquo;'; ?> <?= Configure::read('Site.name') ?></title>

	<?= $html->charset('UTF-8'); ?>

    <?= $html->css(am($css_for_layout,__('TEXT DIRECTION',true))) ?>
	<?
	$html->css('tags', null, null, false);
	$html->css('main', null, null, false);
	$html->css('layout', null, null, false);
	$html->css('recordset', null, null, false);
	$html->css('menu', null, null, false);
	$html->css('mp3_player', null, null, false);
	$html->css('lesson_navigation', null, null, false);
	$html->css('lessons', null, null, false);
	$html->css('books', null, null, false);
	$html->css('chapters', null, null, false);
	$html->css('files', null, null, false);
	$html->css('edit_page', null, null, false);
	$html->css('chat', null, null, false);
	$html->css('assessment', null, null, false);
	$html->css('panel', null, null, false);
	$html->css('classroom', null, null, false);

	echo $asset->css_for_layout();
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->

	<script type="text/javascript" src="/js/tinymce/tiny_mce_popup.js"></script>

	<script>
	function chooseFile(obj) {
		URL = obj.getAttribute('href');
		var win = tinyMCE.getWindowArg("window");
		win.document.getElementById(tinyMCE.getWindowArg("input")).value = URL;
		if (win.getImageData) win.getImageData();
		tinyMCEPopup.close();

		return false;
	}
	</script>
</head>

<body onnload="tinyMCEPopup.executeOnLoad('myInitFunction();');">

<div id="gclms-page">
	<?= $content_for_layout ?>
	<script type="text/javascript" src="/js/vendors/prototype.js"></script>
	<style>
	.list {list-style:square;width:500px;padding-left:16px;}
	.list li{padding:2px;font-size:8pt;}

	pre {
	   font-size:11px;
	}

	.x-tab-panel-body .x-panel-body {
	    padding:10px;
	}
	</style>

	<script>
	var allLinks = document.getElementsByTagName("link");
	allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
	</script>
</div>
</body>
</html>