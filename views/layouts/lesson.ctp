<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $language ?>" dir="<? __('TEXT DIRECTION'); ?>">

<? include 'views/layouts/head.ctp'; ?>

<body
	lms:group="<?= @$group['web_path'] ?>"
	lms:course="<?= @$course['web_path'] ?>"
	class="page"
	<?
	if(!empty($page['Page']['id']))
		echo 'page:id="' . $page['Page']['id'] . '" ';

	if(!empty($facilitated_class['id']))
		echo 'section:id="' . $facilitated_class['id'] . '"';
	?>
	>

<div id="gclms-page">
	<?= $content_for_layout; ?>
</div>

<script type="text/javascript" src="/js/<?= JS_FILE ?>"></script>
<?= $scripts_for_layout; ?>

</body>
</html>