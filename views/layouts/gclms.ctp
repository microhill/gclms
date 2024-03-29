<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Configure::read('Config.language') ?>" dir="<?= empty($text_direction) ? 'ltr' : $text_direction ?>">
<? include 'views/layouts/head.ctp'; ?>
<body
		<? if($this->name != 'CakeError'): ?>
		gclms-group="<?= Group::get('web_path') ?>"
		gclms-course="<?= Course::get('web_path') ?>"
		<? endif; ?>
		<? if(!empty($class)): ?>gclms-class="<?= @$class['id'] ?>"<? endif; ?>
		gclms-controller="<?= @$this->params['controller'] ?>"
		gclms-action="<?= $this->action ?>"
		gclms-direction="<?= empty($text_direction) ? 'ltr' : $text_direction ?>"
		gclms-language="<? $language_code_parts = explode('-',Configure::read('Config.language')); echo $language_code_parts[0]; ?>">
	<div style="min-height: 100%;">
		<?= $this->element('banner') ?>
		
		<?
		if(!@$offline)
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