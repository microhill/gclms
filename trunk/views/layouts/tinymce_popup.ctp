<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">

<head>
	<title><?= $title_for_layout ?> <? if(!empty($title_for_layout)) echo '&raquo;'; ?> <?= Configure::read('Site.name') ?></title>

	<?= $html->charset('UTF-8'); ?>
	<?= $asset->css_for_layout();
	?>
	<!--[if lte IE 6]><?= $html->css('ie6_or_less') ?><![endif]-->
	<!--[if lte IE 7]><?= $html->css('ie7_or_less') ?><![endif]-->

	<script type="text/javascript" src="/js/vendors/tinymce3.0.4/tiny_mce_popup.js"></script>

	<script>
	var FileBrowserDialogue = {
	    init : function () {
	        // Here goes your code for setting your custom things onLoad.
	    },
	    chooseFile : function (obj) {
			URL = obj.getAttribute('href');
			var win = tinyMCEPopup.getWindowArg("window");
			win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
			win.document.getElementById('width').value = obj.getAttribute('image:width');
			win.document.getElementById('height').value = obj.getAttribute('image:height');		
			if (win.getImageData) win.getImageData();
			tinyMCEPopup.close();
	
			return false;
	    }
	}
	
	tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
	</script>
</head>

<body>

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
	//var allLinks = document.getElementsByTagName("link");
	//allLinks[allLinks.length-1].parentNode.removeChild(allLinks[allLinks.length-1]);
	</script>
</div>
</body>
</html>