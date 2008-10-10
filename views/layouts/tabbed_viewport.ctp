<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? echo $text_direction; ?>">
	<head>
		<title>Forum - <?= $group['name'] ?></title>
	
	    <?= $html->css(am('recordset','forum',$css_for_layout,$text_direction;)) ?>
	</head>
	
	<body
		gclms-group="<?= @Group::get('web_path') ?>"
		gclms-course="<?= @$course['web_path'] ?>"
	>
		<?=  $content_for_layout; ?>	
		<?
		echo $asset->js_for_layout();
		?>
	</body>
</html>