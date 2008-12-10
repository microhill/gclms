<div class="gclms-right-column">
	<?
	if($text_direction == 'rtl') {
		if(!empty($primary_column))
			echo $primary_column;
		else
			echo $this->element('primary_column');
	} else {
		if(!empty($secondary_column))
			echo $secondary_column;
		else
			echo $this->element('secondary_column');
	}
	?>
</div>