<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">
	<head>
		<title><?= $page['Page']['title'] ?> - <?= $group['name'] ?></title>
	
	    <?= $html->css(am('page',$css_for_layout,__('TEXT DIRECTION',true))) ?>
		<?	
		//$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		echo '<link rel="stylesheet" type="text/css" href="' . $groupAndCoursePath . '/files/css/1' . '" />';
		?>
	</head>
	
	<body
		lms:group="<?= @$group['web_path'] ?>"
		lms:course="<?= @$course['web_path'] ?>"
		lms:controller="<?= $this->name ?>"
		lms:action="<?= $this->action ?>"
	>
		<?=  $content_for_layout; ?>
		<script type="text/javascript" src="/js/vendors/prototype.js"></script>
		<script type="text/javascript" src="/js/prototype_extensions.js"></script>		
		<script type="text/javascript" src="/js/vendors/scriptaculous1.7.0//scriptaculous.js"></script>
		<script type="text/javascript" src="/js/vendors/scriptaculous1.7.0//effects.js"></script>
		<script type="text/javascript" src="/js/vendors/scriptaculous1.7.0//dragdrop.js"></script>
		<script type="text/javascript" src="/js/vendors/scriptaculous1.7.0//slider.js"></script>
		<script type="text/javascript" src="/js/vendors/mp3_player.js"></script>
		<script type="text/javascript" src="/js/gclms.js"></script>		
		<script type="text/javascript" src="/js/page.js"></script>	
	</body>
</html>