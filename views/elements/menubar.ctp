<div class="gclms-menubar">
	<? foreach($buttons as $button): ?>
		<button id="<?= $button['id'] ?>" class="<?= $button['class'] ?>"
		<?
		
		if(!empty($button['accesskey'])) {
			echo 'accesskey="' . $button['accesskey'] . '"';
		}
		
		if(!empty($button['strings'])) {
			foreach($button['strings'] as $name => $value) {
				echo $name . '="' . __($value,true) . '" ';
			}
		}
		?>
		>
			<? __($button['label']) ?>
		</button>
	<? endforeach; ?>
</div> 