<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" [
	<!ATTLIST body gclms-group CDATA #IMPLIED>
	<!ATTLIST body gclms-course CDATA #IMPLIED>
	<!ATTLIST body gclms-controller CDATA #IMPLIED>
	<!ATTLIST body gclms-action CDATA #IMPLIED>
	<!ATTLIST body gclms-direction CDATA #IMPLIED>
	<!ATTLIST body gclms-language CDATA #IMPLIED>
]>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<?= $text_direction ?>">
	<head>
		<title><?= $page['Page']['title'] ?> - <?= $group['name'] ?></title>
	
	    <?= $html->css(am('page',$css_for_layout,$text_direction)) ?>
		<?	
		//$cssLastUpdated = empty($group['css_updated']) ? '' : '/' . $group['css_updated'] . '.css';
		echo '<link rel="stylesheet" type="text/css" href="' . $groupAndCoursePath . '/files/css/1' . '" />';
		?>
	</head>
	
	<body
		gclms-group="<?= Group::get('web_path') ?>"
		gclms-course="<?= Course::get('web_path') ?>"
		gclms-controller="<?= $this->name ?>"
		gclms-action="<?= $this->action ?>"
	>
		<?=  $content_for_layout; ?>
		<script type="text/javascript" src="/js/vendors/prototype.js"></script>
		<script type="text/javascript" src="/js/prototype_extensions.js"></script>		
		<script type="text/javascript" src="/js/vendors/scriptaculous1.8.1/effects.js"></script>
		<script type="text/javascript" src="/js/vendors/scriptaculous1.8.1/dragdrop.js"></script>
		<script type="text/javascript" src="/js/vendors/scriptaculous1.8.1/slider.js"></script>
		<script type="text/javascript" src="/js/vendors/mp3_player.js"></script>
		<script type="text/javascript" src="/js/gclms.js"></script>		
		<script type="text/javascript" src="/js/page.js"></script>	
	</body>
</html>