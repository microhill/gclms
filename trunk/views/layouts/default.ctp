<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? __('TEXT DIRECTION'); ?>">
<? include 'views/layouts/head.ctp'; ?>

<body
		gclms:group="<?= @$group['web_path'] ?>"
		gclms:course="<?= @$course['web_path'] ?>"
		gclms:controller="<?= $this->name ?>"
		gclms:action="<?= $this->action ?>"
		gclms:direction="<? __('TEXT DIRECTION'); ?>"
		gclms:language="<?= Configure::read('Config.language') ?>">
	<div style="min-height: 100%;">
		<?= $this->renderElement('banner') ?>
		
		<?
		echo $this->renderElement('user_bar');
		echo $this->renderElement('breadcrumbs');
		?>
		
		<div id="gclms-page">
			<?= $content_for_layout; ?>
		</div>
	</div>

	<?= $asset->js_for_layout(); ?>
</body>
</html>