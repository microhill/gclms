<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">
	<head>
		<title><?= $group['name'] ?></title>
	
	    <?= $html->css(am('main','classroom_panel',$css_for_layout,__('TEXT DIRECTION',true))) ?>
		
		<?	
		//$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		//echo '<link rel="stylesheet" type="text/css" href="' . $groupAndCoursePath . '/files/css/1' . '" />';
		?>
	</head>
	
	<body
			gclms:group="<?= @$group['web_path'] ?>"
			gclms:course="<?= @$course['web_path'] ?>"
			gclms:controller="<?= $this->name ?>"
			gclms:action="<?= $this->action ?>">
		<?
		echo $content_for_layout;
		echo $asset->js_for_layout();
		?>
	</body>
</html>