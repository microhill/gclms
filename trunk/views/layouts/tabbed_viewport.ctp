<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">
	<head>
		<title>Forum - <?= $group['name'] ?></title>
	
	    <?= $html->css(am('recordset','forum',$css_for_layout,__('TEXT DIRECTION',true))) ?>
	</head>
	
	<body
		lms:group="<?= @$group['web_path'] ?>"
		lms:course="<?= @$course['web_path'] ?>"
	>
		<?=  $content_for_layout; ?>	
		<?
		echo $asset->js_for_layout();
		?>
	</body>
</html>