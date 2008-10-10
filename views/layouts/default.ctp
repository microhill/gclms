<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<?= $text_direction ?>">
<? include 'views/layouts/head.ctp'; ?>
<body
		gclms-group="<?= @Group::get('web_path') ?>"
		gclms-course="<?= @$course['web_path'] ?>"
		<? if(!empty($class)): ?>gclms-class="<?= @$class['id'] ?>"<? endif; ?>
		gclms-controller="<?= $this->params['controller'] ?>"
		gclms-action="<?= $this->action ?>"
		gclms-direction="<?= $text_direction ?>"
		gclms-language="<?= Configure::read('Config.language') ?>">
	<div style="min-height: 100%;">
		<?= $this->element('banner') ?>
		
		<?
		if(!$offline)
			echo $this->element('user_bar');
			
		echo $this->element('breadcrumbs');
		?>
		
		<div id="gclms-page" class="gclms-noframes">
			<?= $content_for_layout; ?>
		</div>
	</div>

	<?= $asset->js_for_layout(); ?>
	<?= $this->element('all_translated_phrases'); ?>
</body>
</html>