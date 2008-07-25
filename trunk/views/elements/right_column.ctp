<? if(!$framed): ?>
<div class="gclms-right-column">
	<?= $text_direction == 'rtl' ? $this->element('primary_column') : $this->element('secondary_column'); ?>
</div>
<? endif; ?>