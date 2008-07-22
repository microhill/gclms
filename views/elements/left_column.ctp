<? if($framed): ?>
	<?= $this->element('no_column_background'); ?>
<? else: ?>
<div class="gclms-left-column">
	<?= $text_direction == 'rtl' ? $this->element('secondary_column') : $this->element('primary_column'); ?>
</div>
<? endif; ?>