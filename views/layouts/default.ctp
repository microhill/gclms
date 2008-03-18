<?=$html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<? __('TEXT DIRECTION'); ?>">
<? include 'views/layouts/head.ctp'; ?>

<body
		gclms:group="<?= @$group['web_path'] ?>"
		gclms:course="<?= @$course['web_path'] ?>"
		gclms:controller="<?= $this->name ?>"
		gclms:action="<?= $this->action ?>">
	<div style="min-height: 100%;">
		<?= $this->renderElement('banner') ?>
		
		<?= implode(order(array(
			$this->renderElement('user_bar'),
			$this->renderElement('breadcrumbs')
		))); ?>
		
		<div id="gclms-page">
			<?= $content_for_layout; ?>
		</div>
	</div>

	<?= $asset->js_for_layout(); ?>
</body>
</html>