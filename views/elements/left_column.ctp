<? if($framed): ?>
<? else: ?>
<div class="gclms-left-column">
	<?
	if($text_direction == 'rtl') {
		if(!empty($secondary_column))
			echo $secondary_column;
		else
			echo $this->element('secondary_column');
	} else {
		if(!empty($primary_column))
			echo $primary_column;
		else
			echo $this->element('primary_column');
	}
	?>
</div>
<? endif; ?>